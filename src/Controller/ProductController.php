<?php

namespace App\Controller;

use App\Entity\Product;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ProductController extends AbstractController
{
    #[Route('/product', name: 'app_product')]
    public function index(): Response
    {
        return $this->render('product/index.html.twig', [
            'controller_name' => 'ProductController',
        ]);
    }
    #[Route('/product/search/{searchstring}', name: 'product.search')]
    public function searchClients(ProductRepository $productRepository, string $searchstring): Response
    {
        $fields = ['name', 'description', 'price','stock']; // Fields to search on
        $products = $productRepository->searchEntities($fields, $searchstring);

        return $this->render('product/index.html.twig', ['products' => $products]);
    }
}
