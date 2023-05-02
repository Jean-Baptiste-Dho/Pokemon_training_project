<?php

namespace App\Security\Voter;

use App\Entity\CapturedPokemon;
use App\Entity\Dresseur;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class PokemonVoter extends Voter
{
    public const UPDATE = 'update';
    public const DELETE = 'delete';

    protected function supports(string $attribute, mixed $subject): bool
    {
        return in_array($attribute, [self::UPDATE, self::DELETE])
            && $subject instanceof CapturedPokemon;
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();
        if (!$user instanceof UserInterface) {
            return false;
        }

        switch ($attribute) {
            case self::UPDATE:
                return $this->canUpdate($subject, $token->getUser());
                break;
            case self::DELETE:
                return $this->canDelete($subject, $token->getUser());
                break;
        }

        return false;
    }

    private function canUpdate(CapturedPokemon $pokemon, Dresseur $dresseur)
    {
        return $dresseur === $pokemon->getDresseur();
    }

    private function canDelete(CapturedPokemon $pokemon, Dresseur $dresseur)
    {
        return $dresseur === $pokemon->getDresseur();
    }
}
