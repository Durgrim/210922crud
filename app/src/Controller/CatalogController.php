<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/*
class CatalogController extends AbstractController {
    #[Route('/catalog', name: 'app_catalog')]
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/CatalogController.php',
        ]);
    }
}
*/ 
class CatalogController extends AbstractController {
    public function index(){
        return $this->render('products/products.html.twig');
    }
}