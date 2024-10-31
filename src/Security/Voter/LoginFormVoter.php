<?php

namespace App\Security\Voter;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class LoginFormVoter extends Voter
{
    public const FORM_SUBMIT = 'FORM_SUBMIT';

    protected function supports(string $attribute, mixed $subject): bool
    {
        // Seuls les utilisateurs autorisés peuvent soumettre ce formulaire
        return $attribute === self::FORM_SUBMIT;
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();

        // Vérifier que l'utilisateur est connecté
        if (!$user instanceof UserInterface) {
            return false;
        }

        // Vérifiez ici les rôles de l'utilisateur pour autoriser l'accès
        // Supposons que seul un utilisateur avec le rôle ROLE_ADMIN peut soumettre le formulaire
        return in_array('ROLE_ADMIN', $user->getRoles(), true);
    }
}
