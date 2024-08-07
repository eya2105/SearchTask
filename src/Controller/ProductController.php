<?php

namespace App\Controller;

use App\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    #[Route('/products/{id}', name: 'app_product_show')]
    public function show(Product $product): Response
    {
        // Symfony automatically fetches the Product entity
        return $this->render('product/show.html.twig', [
            'product' => $product,
        ]);
    }
}
