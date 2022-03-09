<?php

namespace App\Security\Voter;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;

class ApiUserVoter extends Voter
{
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    protected function supports(string $attribute, $subject): bool
    {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        return in_array($attribute, ['USER_EDIT', 'USER_READ'])
            && $subject instanceof \App\Entity\User;
    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }

        // ... (check conditions and return true to grant permission) ...
        switch ($attribute) {
            case 'USER_EDIT':

                // Checking if the connected user is the one asking for edit on a user
                if ($this->security->isGranted('ROLE_ADMIN')) {
                    return true;
                }

                // Checking if the connected user is the one asking for edit on a user
                if ($user === $subject) {
                    return true;
                }

                return false;

                break;

            case 'USER_READ':

                // Checking if the connected user is the one asking for edit on a user
                if ($this->security->isGranted('ROLE_ADMIN')) {
                    return true;
                }

                // Checking if the connected user is the one asking for edit on a user
                if ($user === $subject) {
                    return true;
                }

                return false;

                break;
        }

        return false;
    }
}
