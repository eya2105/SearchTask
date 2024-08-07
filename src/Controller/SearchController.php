<?php

namespace App\Controller;

use App\Form\SearchType;
use App\Service\SearchService;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SearchController extends AbstractController
{
    private SearchService $searchService;

    public function __construct(SearchService $searchService)
    {
        $this->searchService = $searchService;
    }
    /**
     * @throws Exception
     */
    #[Route('/searchAll', name: 'app_search_all')]
    public function searchAll(Request $request): Response
    {
        $form = $this->createForm(SearchType::class);
        $form->handleRequest($request);

        $results = [];

        if ($form->isSubmitted() && $form->isValid()) {
            $searchString = $form->get('search')->getData();
            $results = $this->searchService->searchAllEntities('intern', $searchString);
        }

        return $this->render('search/indexALL.html.twig', [
            'form' => $form->createView(),
            'results' => $results,
        ]);
    }
}
