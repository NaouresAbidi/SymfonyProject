<?php

namespace App\Controller;

use App\Entity\Item;
use App\Form\ItemType;
use App\Repository\ItemRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ItemController extends AbstractController
{
    #[Route('/item', name: 'app_item_index')]
    public function index(ItemRepository $itemRepository): Response
    {
        $items = $itemRepository->findAll();

        return $this->render('item/item.html.twig', [
            'items' => $items,
        ]);
    }

    #[Route('/item/new', name: 'app_item_new')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $item = new Item();
        $form = $this->createForm(ItemType::class, $item);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $uploadedFile = $form->get('imagepath')->getData(); // Get the uploaded file

            if ($uploadedFile) {
                // Define the directory where the image will be uploaded
                $uploadDirectoryItem = $this->getParameter('uploadDirectoryItem'); // e.g., 'public/uploads/items'
                $newFilename = uniqid() . '.' . $uploadedFile->guessExtension(); // Generate a unique file name

                // Move the uploaded file to the upload directory
                $uploadedFile->move(
                    $uploadDirectoryItem,
                    $newFilename
                );

                // Set the file path in the item entity
                $item->setImagepath('/uploads/items/' . $newFilename); // Adjust based on your upload path
            }

            $entityManager->persist($item);
            $entityManager->flush();

            $this->addFlash('success', 'Item created successfully!');

            return $this->redirectToRoute('app_item_index');
        }

        return $this->render('item/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/item/{id}/edit', name: 'app_item_edit')]
    public function edit(Item $item, Request $request, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ItemType::class, $item);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $uploadedFile = $form->get('imagepath')->getData(); // Get the uploaded file

            if ($uploadedFile) {
                // Define the directory where the image will be uploaded
                $uploadDirectoryItem = $this->getParameter('uploadDirectoryItem'); // e.g., 'public/uploads/items'
                $newFilename = uniqid() . '.' . $uploadedFile->guessExtension(); // Generate a unique file name

                // Move the uploaded file to the upload directory
                $uploadedFile->move(
                    $uploadDirectoryItem,
                    $newFilename
                );

                // Set the new file path in the item entity
                $item->setImagepath('/uploads/items/' . $newFilename); // Adjust based on your upload path
            }

            $entityManager->flush();

            $this->addFlash('success', 'Item updated successfully!');

            return $this->redirectToRoute('app_item_index');
        }

        return $this->render('item/edit.html.twig', [
            'form' => $form->createView(),
            'item' => $item,
        ]);
    }

    #[Route('/item/{id}/delete', name: 'app_item_delete')]
    public function delete(Item $item, EntityManagerInterface $entityManager): Response
    {
        $entityManager->remove($item);
        $entityManager->flush();

        $this->addFlash('success', 'Item deleted successfully!');

        return $this->redirectToRoute('app_item_index');
    }
}
