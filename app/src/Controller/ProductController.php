<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Product;

class ProductController extends AbstractController {

    public function getProducts(ManagerRegistry $doctrine): Response {
        $entityManager = $doctrine->getManager();
        $listProducts = $entityManager->getRepository(Product::class)->findAll();

        return $this->render('products/products.html.twig', [
            'listProducts' => $listProducts,
        ]);
    }
}