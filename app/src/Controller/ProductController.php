<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Product;
use App\Security\userDisabledException;

class ProductController extends AbstractController {

    public function main(): Response {
        return $this->redirectToRoute('getProducts');
    }

    public function getProducts(ManagerRegistry $doctrine): Response {
        $entityManager = $doctrine->getManager();
        $listProducts = $entityManager->getRepository(Product::class)->findAll();
        return $this->render('products/products.html.twig', [
            'listProducts' => $listProducts,
        ]);
    }

    public function getSingleProduct($id, ManagerRegistry $doctrine): Response {
        $entityManager = $doctrine->getManager();
        $product = $entityManager->getRepository(Product::class)->find($id);
        if(!$product){
            $this->addFlash('error', "The product doesn't exist");
            return $this->redirectToRoute('getProducts');
        } elseif(!$product->isEnabled()){
            $this->addFlash('error', 'The product is not active, full information cannot be accessed');
            return $this->redirectToRoute('getProducts');
        } else {
            return $this->render('products/singleProduct.html.twig', [
                'product' => $product,
            ]);
        }
    }

    public function createProduct(Request $request, ManagerRegistry $doctrine): Response {
        $entityManager = $doctrine->getManager();
        $product = new \App\Entity\Product();
        $formProduct = $this->createForm(\App\Form\ProductType::class, $product);
        $formProduct->handleRequest($request);
        if($formProduct->isSubmitted() && $formProduct->isValid()){
            $entityManager->persist($product);
            $entityManager->flush();
            $this->addFlash('success', 'The product had been created');
            return $this->redirectToRoute('getProducts');
        }
        return $this->render('products/productCreate.html.twig', [
            'formProduct' => $formProduct->createView(),
        ]);
    }

    public function updateProduct($id, Request $request, ManagerRegistry $doctrine): Response {
        $entityManager = $doctrine->getManager();
        $product = $entityManager->getRepository(Product::class)->find($id);
        if(!$product){
            $this->addFlash('error', "The product doesn't exist");
            return $this->redirectToRoute('getProducts');
        } elseif(!$product->isEnabled()){
            $this->addFlash('error', 'The product is not active, cannot be modified');
            return $this->redirectToRoute('getProducts');
        } else {
            $formProduct = $this->createForm(\App\Form\ProductType::class, $product);
            $formProduct->handleRequest($request);
            if($formProduct->isSubmitted() && $formProduct->isValid()){
                $entityManager->flush();
                $this->addFlash('success', 'The product had been updated');
                return $this->redirectToRoute('getProducts');
            }
            return $this->render('products/productUpdate.html.twig', [
                'formProduct' => $formProduct->createView(),
                'product' => $product,
            ]);
        }
    }

    public function deleteProduct($id, ManagerRegistry $doctrine): Response {
        $entityManager = $doctrine->getManager();
        $product = $entityManager->getRepository(Product::class)->find($id);
        if(!$product){
            $this->addFlash('error', 'The product do not exist.');
            return $this->redirectToRoute('getProducts');
        } else {
            $entityManager->remove($product);
            $entityManager->flush();
            $this->addFlash('success', 'The product had been deleted');
            return $this->redirectToRoute('getProducts');
        }
    }
}