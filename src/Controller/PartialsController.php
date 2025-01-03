<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Repository\MenuRepository;

class PartialsController extends AbstractController
{
    // This method will handle rendering the navigation with dynamic menu items.
    public function nav(): Response
    {
        $menuItems = [
            ['name' => 'Item', 'route' => '/item'],
            ['name' => 'Menu', 'route' => '/menu'],
            ['name' => 'Category', 'route' => '/category'],
        ];

        return $this->render('partials/nav.html.twig', [
            'menuItems' => $menuItems,
        ]);
    }

    // This method will handle rendering the header (it could be dynamic in the future).
    public function header(): Response
    {
        return $this->render('partials/header.html.twig');
    }


    // This method will handle rendering the footer.
    public function footer(): Response
    {
        return $this->render('partials/footer.html.twig');
    }
}
