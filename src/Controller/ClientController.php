<?php

namespace App\Controller;

use App\Entity\Client;
use App\Form\ClientType;
use App\Repository\ClientRepository;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ClientController extends AbstractController
{
    #[Route('/clients', name: 'clients.index', methods: ['GET'])]
    public function index(ClientRepository $clientRepository): Response
    {
        /*
            Les methodes de repository permet de récupérer les données d'une entité
            findALL():retourne tous les objets de la classe
            find($id):retourne un objet en fonction de son id
            findOneBy(['field' =>'valeur']):retourne un objet en fonction de ses attributs


        */
        $clients=$clientRepository->findAll();
        return $this->render('client/index.html.twig', [
            'clients' => $clients
        ]);
    }
    //parametre facultative {va?}
    //on peut faire soite comme ça Route('/clients/search/telephone/{telephone}'
    //ou bien comme ça Route('/clients/search/telephone/{?tel=la_valeur}'
    //utilisation des path variables
    #[Route('/clients/show/{id?}', name: 'clients.show', methods: ['GET'])]
    public function show(int $id): Response
    {
        dd($id);
        return $this->render('client/index.html.twig', [
            'controller_name' => 'ClientController',
        ]);
    }

    
    //On utilise les query parenths pour faire la pagination et ça contient seulement 255 caractères
    //{} path variable

    //utilisation des query params
    #[Route('/clients/search/telephone', name: 'clients.searchClientByTelephone', methods: ['POST'])]
    public function searchClientByTelephone(Request $request, ClientRepository $clientRepository): Response
    {
        //query=>$_GET
        //request=>$_POST
        //$request->query-> get('key')=>$_GET['key']
        //$request->request-> get('name_field')=>$_POST['name_field']
        // $telephone = $request->query-> get('tel');
        $clients = $clientRepository->findOneBy(['telephone' =>$request->request-> get('telephone')]);
        return $this->render('client/index.html.twig', [
            'clients' => $clients
        ]);
    }


    #[Route('/clients/remove/{id?}', name: 'clients.remove', methods: ['GET'])]
    public function remove(int $id): Response
    {
        dd($id);
        return $this->render('client/index.html.twig', [
            'controller_name' => 'ClientController',
        ]);
    }

    //si on met rien au niveau de #[Route('/clients/store', name: 'clients.store')] 
    //ça veut dire cette méthode peut être appelée par POST ou GET
    #[Route('/clients/store', name: 'clients.store', methods: ['GET', 'POST'])]
    public function store(Request $request, EntityManagerInterface $entityManager): Response
    {
        
        $client = new Client();
        //Association de l'objet client  au Formulaire
        $form=$this->createForm(ClientType::class, $client);
        //Récupération des données du formulaire
        $form->handleRequest($request);
       
        if ($form->isSubmitted()) {
            $client->setCreateAt(new \DateTimeImmutable());
            $client->setUpdateAt(new \DateTimeImmutable());

            $entityManager->persist($client);//Stocker en mémoire mais n'est pas encore exécuté au niveau de la base de donnée
            $entityManager->flush();//exécute la requête en base de donnée et est l'équivalent du commit en java

            return $this->redirectToRoute('Clients.index');
        }
        return $this->render('client/form.html.twig', [
            'formClient' => $form->createView(),
        ]);
    }
}
