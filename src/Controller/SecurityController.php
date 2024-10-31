<?php

namespace App\Controller;

use App\Security\Voter\LoginFormVoter;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        if (!$this->isGranted(LoginFormVoter::FORM_SUBMIT)) {
            // Optionnel : rediriger l’utilisateur vers une page d’erreur ou un accès restreint
            return $this->redirectToRoute('access_denied');
        }
    
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

//     public function login(AuthenticationUtils $authenticationUtils): Response
// {
//     if (!$this->isGranted(LoginFormVoter::FORM_SUBMIT)) {
//         // Optionnel : rediriger l’utilisateur vers une page d’erreur ou un accès restreint
//         return $this->redirectToRoute('access_denied');
//     }

//     $error = $authenticationUtils->getLastAuthenticationError();
//     $lastUsername = $authenticationUtils->getLastUsername();

//     return $this->render('security/login.html.twig', [
//         'last_username' => $lastUsername,
//         'error' => $error
//     ]);
// }

}
