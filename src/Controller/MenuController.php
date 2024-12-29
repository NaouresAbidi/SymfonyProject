<?php

namespace App\Controller;

use App\Entity\Menu;
use App\Form\MenuType;
use App\Repository\MenuRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MenuController extends AbstractController
{
    // Main route
    #[Route('/menu', name: 'app_menu_index')]
    public function index(MenuRepository $menuRepository): Response
    {
        $menus = $menuRepository->findAll();

        return $this->render('menu/menu.html.twig', [
            'menus' => $menus,
        ]);
    }

    // Create
    #[Route('/menu/new', name: 'app_menu_new')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $menu = new Menu();
        $form = $this->createForm(MenuType::class, $menu);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $uploadedFile = $form->get('image')->getData();
            if ($uploadedFile) {
                $uploadDirectory = $this->getParameter('uploadDirectoryMenu'); // Fetch the parameter
                $newFilename = uniqid() . '.' . $uploadedFile->guessExtension();
                $uploadedFile->move($uploadDirectory, $newFilename);

                $menu->setImagePath('/uploads/menus/' . $newFilename);
            }
            $entityManager->persist($menu);
            $entityManager->flush();

            return $this->redirectToRoute('app_menu_index');
        }

        return $this->render('menu/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    // Edit
    #[Route('/menu/{id}/edit', name: 'app_menu_edit')]
    public function edit(Request $request, Menu $menu, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(MenuType::class, $menu);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $uploadedFile = $form->get('image')->getData();
            if ($uploadedFile) {
                // Handle the new file upload
                $uploadDirectory = $this->getParameter('uploadDirectoryMenu'); // Fetch the parameter
                $newFilename = uniqid() . '.' . $uploadedFile->guessExtension();
                $uploadedFile->move($uploadDirectory, $newFilename);

                // Update the image path in the menu
                $menu->setImagePath('/uploads/menus/' . $newFilename);
            }
            // If no new file was uploaded, the existing imagePath will remain the same
            $entityManager->flush();

            return $this->redirectToRoute('app_menu_index');
        }

        return $this->render('menu/edit.html.twig', [
            'form' => $form->createView(),
            'menu' => $menu,
        ]);
    }

    // Delete
    #[Route('/menu/{id}/delete', name: 'app_menu_delete', methods: ['POST'])]
    public function delete(Request $request, Menu $menu, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $menu->getId(), $request->request->get('_token'))) {
            $entityManager->remove($menu);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_menu_index');
    }
}
