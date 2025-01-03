<?php
// src/Controller/BrowsingController.php

namespace App\Controller;

use App\Repository\MenuRepository;
use App\Repository\ItemRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BrowsingController extends AbstractController
{
    #[Route('/browse', name: 'app_browse')]
    public function index(MenuRepository $menuRepository, ItemRepository $itemRepository): Response
    {
        $menus = $menuRepository->findAll(); // Get all menus
        $items = $itemRepository->findAll(); // Get all items

        return $this->render('browsing/index.html.twig', [
            'menus' => $menus,
            'items' => $items,
        ]);
    }
    #[Route('/menu-details/{id}', name: 'menu_details', methods: ['GET'])]
    public function menuDetails(int $id, MenuRepository $menuRepository): JsonResponse
    {
        $menu = $menuRepository->find($id);

        if (!$menu) {
            return $this->json(['error' => 'Menu not found'], Response::HTTP_NOT_FOUND);
        }

        return $this->json([
            'id' => $menu->getId(),
            'name' => $menu->getName(),
            'description' => $menu->getDescription(),
            'regularPrice' => $menu->getRegularPrice(), // Adjust according to your entity
            'dealPrice' => $menu->getDealPrice(), // Adjust according to your entity
        ]);
    }



}
