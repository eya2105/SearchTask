<?php

// src/Controller/SearchController.php

namespace App\Controller;

use App\Form\SearchType;
use App\Repository\ClientRepository;
use App\Repository\FactureRepository;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SearchController extends AbstractController
{
    #[Route('/search', name: 'app_search')]
    public function index(Request $request, ProductRepository $productRepository, FactureRepository $factureRepository, ClientRepository $clientRepository): Response
    {
        // Create the search form
        $form = $this->createForm(SearchType::class);
        $form->handleRequest($request);

        $products = $clients = $factures = [];

        if ($form->isSubmitted() && $form->isValid()) {
            // Get the search string from the form
            $searchString = $form->get('search')->getData();

            // Search in repositories
            $fields = ['name', 'description', 'price', 'stock'];
            $products = $productRepository->searchEntities($fields, $searchString);

            $fields = ['firstname', 'lastname', 'email'];
            $clients = $clientRepository->searchEntities($fields, $searchString);

            $fields = ['description'];
            $factures = $factureRepository->searchEntities($fields, $searchString);
        }

        return $this->render('search/index.html.twig', [
            'controller_name' => 'SearchController',
            'form' => $form->createView(),
            'clients' => $clients,
            'products' => $products,
            'factures' => $factures,
        ]);
    }
}
