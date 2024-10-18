<?php

namespace App\Controller;

use App\Repository\DetteRepository;
use App\Repository\ClientRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DetteController extends AbstractController
{
    #[Route('/dettes', name: 'dettes.index', methods: ['GET'])]
    public function index(Request $request, ClientRepository $clientRepository, DetteRepository $detteRepository, SessionInterface $session): Response
    {
        $session->set('id',$request->query->get('clientId'));
        $clientId =$session->get('id');
        $client = $clientRepository->find($clientId);

        $page =  $request->query->getInt('page',1);
        $limit = 2;
        $dettes = $detteRepository->paginateDettesByClient($client, $page, $limit);
        $count = $dettes->count();
        $maxPage =  ceil($count/$limit);
        return $this->render('dette/index.html.twig', [
            'controller_name' => 'DetteController',
            'dettes' => $dettes,
            'page' => $page,//page actuelle
            'maxPage' => $maxPage,
        ]);
    }
}
