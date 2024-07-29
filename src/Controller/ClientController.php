<?php

namespace App\Controller;

use App\Entity\Client;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Doctrine\ORM\EntityManagerInterface;

class ClientController extends AbstractController
{
    #[Route('/clients/{id} ', name: 'app_client_show')]
    public function show(Client $client): Response
    {
        // No need to manually fetch the client; Symfony automatically fetches it
        return $this->render('client/show.html.twig', [
            'client' => $client,
        ]);
    }
}
