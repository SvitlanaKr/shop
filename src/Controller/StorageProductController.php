<?php

namespace App\Controller;

use App\Entity\StorageProduct;
use App\Form\StorageProductType;
use App\Repository\StorageProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/storage_product")
 */
class StorageProductController extends AbstractController
{
    /**
     * @Route("/", name="storage_product_index", methods={"GET"})
     */
    public function index(StorageProductRepository $storageProductRepository): Response
    {
        return $this->render('storage_product/index.html.twig', [
            'storage_products' => $storageProductRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="storage_product_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $storageProduct = new StorageProduct();
        $form = $this->createForm(StorageProductType::class, $storageProduct);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($storageProduct);
            $entityManager->flush();

            return $this->redirectToRoute('storage_product_index');
        }

        return $this->render('storage_product/new.html.twig', [
            'storage_product' => $storageProduct,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="storage_product_show", methods={"GET"})
     */
    public function show(StorageProduct $storageProduct): Response
    {
        return $this->render('storage_product/show.html.twig', [
            'storage_product' => $storageProduct,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="storage_product_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, StorageProduct $storageProduct): Response
    {
        $form = $this->createForm(StorageProductType::class, $storageProduct);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('storage_product_index');
        }

        return $this->render('storage_product/edit.html.twig', [
            'storage_product' => $storageProduct,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="storage_product_delete", methods={"DELETE"})
     */
    public function delete(Request $request, StorageProduct $storageProduct): Response
    {
        if ($this->isCsrfTokenValid('delete'.$storageProduct->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($storageProduct);
            $entityManager->flush();
        }

        return $this->redirectToRoute('storage_product_index');
    }
}
