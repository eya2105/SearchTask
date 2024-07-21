<?php

namespace App\Controller;

use App\Entity\Client;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\ClientRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ClientController extends AbstractController
{
    #[Route('/client', name: 'app_client')]
    public function index(): Response
    {
        return $this->render('client/index.html.twig', [
            'controller_name' => 'ClientController',
        ]);
    }
    #[Route('/client/search/{searchstring}', name: 'client.search')]
    public function searchClients(ClientRepository $clientRepository, string $searchstring): Response
    {
        $fields = ['firstname', 'lastname', 'email']; // Fields to search on
        $clients = $clientRepository->searchEntities($fields, $searchstring);

        return $this->render('client/index.html.twig', ['clients' => $clients]);
    }

}
