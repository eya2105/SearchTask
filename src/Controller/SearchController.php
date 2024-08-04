<?php

namespace App\Controller;

use App\Form\SearchType;
use App\Service\SearchService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SearchController extends AbstractController
{
    private $searchService;

    public function __construct(SearchService $searchService)
    {
        $this->searchService = $searchService;
    }

    #[Route('/search', name: 'app_search')]
    public function search(Request $request): Response
    {
        $form = $this->createForm(SearchType::class);
        $form->handleRequest($request);

        $products = $clients = $factures = [];

        if ($form->isSubmitted() && $form->isValid()) {
            $searchString = $form->get('search')->getData();
            $products = $this->searchService->searchEntities('intern', 'product', ['name', 'description', 'price', 'stock'], $searchString);
            $clients = $this->searchService->searchEntities('intern', 'client', ['firstname', 'lastname', 'email'], $searchString);
            $factures = $this->searchService->searchEntities('intern', 'facture', ['description'], $searchString);
        }

        return $this->render('search/index.html.twig', [
            'form' => $form->createView(),
            'clients' => $clients,
            'products' => $products,
            'factures' => $factures,
        ]);
    }
}
