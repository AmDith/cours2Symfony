<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class UserController extends AbstractController
{
    #[Route('/users', name: 'users.index')]
    public function index(): Response
    {
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }
    #[Route('/users/store', name: 'users.store', methods: ['GET', 'POST'])]
    public function store(Request $request, EntityManagerInterface $entityManager): Response
    {
        
        $client = new User();
        //Association de l'objet client  au Formulaire
        $form=$this->createForm(UserType::class, $client);
        //Récupération des données du formulaire
        $form->handleRequest($request);
       
        if ($form->isSubmitted()) {
            $client->setCreateAt(new \DateTimeImmutable());
            $client->setUpdateAt(new \DateTimeImmutable());

            $entityManager->persist($client);//Stocker en mémoire mais n'est pas encore exécuté au niveau de la base de donnée
            $entityManager->flush();//exécute la requête en base de donnée et est l'équivalent du commit en java

            return $this->redirectToRoute('users.index');
        }
        return $this->render('user/form.html.twig', [
            'formUser' => $form->createView(),
        ]);
    }
}
