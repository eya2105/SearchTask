<?php

namespace App\Controller;

use App\Form\SearchType;
use App\Repository\ClientRepository;
use App\Repository\FactureRepository;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class SearchController extends AbstractController
{
    #[Route('/search', name: 'app_search')]
    public function search (Request $request, ProductRepository $productRepository, FactureRepository $factureRepository, ClientRepository $clientRepository): Response
    {
        $form = $this->createForm(SearchType::class);
        $form->handleRequest($request);

        $products = $clients = $factures = [];

        if ($form->isSubmitted() && $form->isValid()) {
            $searchString = $form->get('search')->getData();
            $products = $productRepository->searchEntities(['name', 'description', 'price', 'stock'], $searchString);
            $clients = $clientRepository->searchEntities(['firstname', 'lastname', 'email'], $searchString);
            $factures = $factureRepository->searchEntities(['description'], $searchString);
        }

        return $this->render('search/index.html.twig', [
            'form' => $form->createView(),
            'clients' => $clients,
            'products' => $products,
            'factures' => $factures,
        ]);
    }

    #[Route('/search/ajax', name: 'app_search_ajax', methods: ['GET'])]
    public function ajaxSearch(Request $request, ProductRepository $productRepository, FactureRepository $factureRepository, ClientRepository $clientRepository): JsonResponse
    {
        $searchString = $request->query->get('search', '');

        $products = $productRepository->searchEntities(['name', 'description', 'price', 'stock'], $searchString);
        $clients = $clientRepository->searchEntities(['firstname', 'lastname', 'email'], $searchString);
        $factures = $factureRepository->searchEntities(['description'], $searchString);

        $data = [
            'products' => array_map(fn($p) => [
                'name' => $p->getName(),
                'description' => $p->getDescription(),
                'price' => $p->getPrice(),
                'stock' => $p->getStock()
            ], $products),
            'clients' => array_map(fn($c) => [
                'firstname' => $c->getFirstname(),
                'lastname' => $c->getLastname(),
                'email' => $c->getEmail()
            ], $clients),
            'factures' => array_map(fn($f) => [
                'description' => $f->getDescription(),
                'quantity' => $f->getQuantity(),
                'totalPrice' => $f->getTotalPrice(),
                'productName' => $f->getProductID() ? $f->getProductID()->getName() : 'N/A',
                'clientName' => $f->getClientID() ? $f->getClientID()->getFirstname() . ' ' . $f->getClientID()->getLastname() : 'N/A'
            ], $factures),
        ];

        return new JsonResponse($data);
    }
}
