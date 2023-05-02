<?php

namespace App\Security\Voter;

use App\Entity\Dresseur;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class UserVoter extends Voter
{

    public const DELETE = 'delete';
    private AuthorizationCheckerInterface $authorizationChecker;

    public function __construct(AuthorizationCheckerInterface $authorizationChecker)
    {
        $this->authorizationChecker = $authorizationChecker;
    }

    protected function supports(string $attribute, mixed $subject): bool
    {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        return in_array($attribute, [self::DELETE])
            && $subject instanceof \App\Entity\Dresseur;
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {

        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }

        // ... (check conditions and return true to grant permission) ...
        switch ($attribute) {
            case self::DELETE:
                // logic to determine if the user can EDIT
                return $this->canDelete($subject, $user);
                break;
        }

        return false;
    }

    private function canDelete(Dresseur $subject, UserInterface $user)
    {
        $now = time();
        $isEven = $now % 2 === 0;
        $isAdmin = $this->authorizationChecker->isGranted('ROLE_ADMIN');

        return ($isEven && $isAdmin);
    }
}
