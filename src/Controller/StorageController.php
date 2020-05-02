<?php

namespace App\Controller;

use App\Entity\Storage;
use App\Form\StorageType;
use App\Repository\StorageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/storage")
 */
class StorageController extends AbstractController
{
    /**
     * @Route("/", name="storage_index", methods={"GET"})
     */
    public function index(StorageRepository $storageRepository): Response
    {
        return $this->render('storage/index.html.twig', [
            'storages' => $storageRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="storage_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $storage = new Storage();
        $form = $this->createForm(StorageType::class, $storage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($storage);
            $entityManager->flush();

            return $this->redirectToRoute('storage_index');
        }

        return $this->render('storage/new.html.twig', [
            'storage' => $storage,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="storage_show", methods={"GET"})
     */
    public function show(Storage $storage): Response
    {
        return $this->render('storage/show.html.twig', [
            'storage' => $storage,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="storage_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Storage $storage): Response
    {
        $form = $this->createForm(StorageType::class, $storage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('storage_index');
        }

        return $this->render('storage/edit.html.twig', [
            'storage' => $storage,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="storage_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Storage $storage): Response
    {
        if ($this->isCsrfTokenValid('delete'.$storage->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($storage);
            $entityManager->flush();
        }

        return $this->redirectToRoute('storage_index');
    }
}
