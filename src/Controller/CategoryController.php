<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
    //main route
    #[Route('/category', name: 'app_category_index')]
    public function index(CategoryRepository $categoryRepository): Response
    {
        $categories = $categoryRepository->findAll();

        return $this->render('category/category.html.twig', [
            'categories' => $categories,
        ]);
    }
//create
    #[Route('/category/new', name: 'app_category_new')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $uploadedFile = $form->get('imagePath')->getData();
            if ($uploadedFile) {
                $uploadDirectory = $this->getParameter('uploadDirectory'); // Fetch the parameter
                $newFilename = uniqid() . '.' . $uploadedFile->guessExtension();
                $uploadedFile->move($uploadDirectory, $newFilename);

                $category->setImagePath('/uploads/categories/' . $newFilename);
            }
            $entityManager->persist($category);
            $entityManager->flush();

            return $this->redirectToRoute('app_category_index');
        }

        return $this->render('category/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

//edit
    //edit
    #[Route('/category/{id}/edit', name: 'app_category_edit')]
    public function edit(Request $request, Category $category, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $uploadedFile = $form->get('imagePath')->getData();
            if ($uploadedFile) {
                // Handle the new file upload
                $uploadDirectory = $this->getParameter('uploadDirectory'); // Fetch the parameter
                $newFilename = uniqid() . '.' . $uploadedFile->guessExtension();
                $uploadedFile->move($uploadDirectory, $newFilename);

                // Update the image path in the category
                $category->setImagePath('/uploads/categories/' . $newFilename);
            }
            // If no new file was uploaded, the existing imagePath will remain the same
            $entityManager->flush();

            return $this->redirectToRoute('app_category_index');
        }

        return $this->render('category/edit.html.twig', [
            'form' => $form->createView(),
            'category' => $category,
        ]);
    }

    //delete
    #[Route('/category/{id}/delete', name: 'app_category_delete', methods: ['POST'])]
    public function delete(Request $request, Category $category, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$category->getId(), $request->request->get('_token'))) {
            $entityManager->remove($category);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_category_index');
    }

}
