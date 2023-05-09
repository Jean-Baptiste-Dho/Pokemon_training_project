<?php

namespace App\Security\Voter;

use App\Entity\Dresseur;
use App\Entity\Trade;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class TradeVoter extends Voter
{
    public const GRANTED = 'GRANTED';
    public const DELETE = 'DELETE';

    protected function supports(string $attribute, mixed $subject): bool
    {
        return in_array($attribute, [self::GRANTED, self::DELETE])
            && $subject instanceof \App\Entity\Trade;
    }


    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }

        switch ($attribute) {
            case self::GRANTED:
                return $this->isGranted($subject, $token->getUser());
                break;
            case self::DELETE:
                return $this->canDelete($subject, $token->getUser());
                break;
        }

        return false;

    }

    private function isGranted(Trade $trade, Dresseur $dresseur): bool
    {
        return $trade->getSeller()->getName() === $dresseur->getName();
    }

    private function canDelete(Trade $trade, Dresseur $dresseur): bool
    {
        return $trade->getSeller()->getName() === $dresseur->getName();
    }


}
