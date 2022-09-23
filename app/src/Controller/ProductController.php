<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Product;

class ProductController extends AbstractController {

    public function getProducts(ManagerRegistry $doctrine): Response {
        $entityManager = $doctrine->getManager();
        //$listProducts = $entityManager->getRepository(Product::class)->findBy(['enabled'=>1]);
        $listProducts = $entityManager->getRepository(Product::class)->findAll();
        return $this->render('products/products.html.twig', [
            'listProducts' => $listProducts,
        ]);
    }

    public function showProduct($id, ManagerRegistry $doctrine): Response {
        $entityManager = $doctrine->getManager();
        $product = $entityManager->getRepository(Product::class)->find($id);

        return $this->render('products/singleProduct.html.twig', [
            'product' => $product,
        ]);
    }

    public function createProduct(Request $request, ManagerRegistry $doctrine): Response {
        $entityManager = $doctrine->getManager();
        $product = new \App\Entity\Product();
        $formProduct = $this->createForm(\App\Form\ProductType::class, $product);
        $formProduct->handleRequest($request);
        // Filter decimals
        if($formProduct->isSubmitted() && $formProduct->isValid()){
            $product->setEnabled(1);
            $entityManager->persist($product);
            $entityManager->flush();
            return $this->redirectToRoute('getProducts');
        }
        return $this->render('products/productCreate.html.twig', [
            'formProduct' => $formProduct->createView(),
        ]);
    }

    public function updateProduct($id, Request $request, ManagerRegistry $doctrine): Response {
        $entityManager = $doctrine->getManager();
        $product = $entityManager->getRepository(Product::class)->find($id);
        $formProduct = $this->createForm(\App\Form\ProductType::class, $product);
        $formProduct->handleRequest($request);
        if($formProduct->isSubmitted() && $formProduct->isValid()){
            $product->setEnabled(1);
            $entityManager->persist($product);
            $entityManager->flush();
            return $this->redirectToRoute('getProducts');
        }
        return $this->render('products/productUpdate.html.twig', [
            'formProduct' => $formProduct->createView(),
        ]);
    }

    public function deleteProduct($id, ManagerRegistry $doctrine): Response {
        $entityManager = $doctrine->getManager();
        $product = $entityManager->getRepository(Product::class)->find($id);
        $product->setEnabled(0);
        $entityManager->remove($product);
        $entityManager->flush();
        return $this->redirectToRoute('getProducts');
    }
}