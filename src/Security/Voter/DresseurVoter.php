<?php

namespace App\Security\Voter;

use App\Entity\CapturedPokemon;
use App\Entity\Dresseur;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class DresseurVoter extends Voter
{
    public const UPDATE = 'update';
    public const VIEW = 'pokemon_create';
    public const CREATE = 'pokemon_create';
    public const DELETE = 'pokemon_delete';

//    private AuthorizationCheckerInterface $authorizationChecker;

    protected function supports(string $attribute, mixed $subject): bool
    {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        return in_array($attribute, [self::UPDATE, self::VIEW, self::DELETE, self::CREATE])
            && $subject instanceof Dresseur;
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }

//        dd($user);
//        $test = $this->authorizationChecker->isGranted('IS_AUTHENTICATED_REMEMBERED');
        // ... (check conditions and return true to grant permission) ...
        switch ($attribute) {
            case self::UPDATE:
                return $this->canEdit($subject, $token->getUser());
                break;
            case self::VIEW:
                // logic to determine if the user can VIEW
                return true;
                break;
            case self::CREATE:
//                si l'utilisateur est le createur, oui, sinon, non
                // logic to determine if the user can VIEW
                return true or false;
                break;
            case self::DELETE:
//                si l'utilisateur est le createur, oui, sinon, non
                // logic to determine if the user can DELETE
                return true or false;
                break;
        }

        return false;
    }

    private function canEdit(CapturedPokemon $pokemon, Dresseur $dresseur)
    {
        return $dresseur === $pokemon->getDresseur();
    }
}
