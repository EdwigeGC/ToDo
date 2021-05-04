<?php

namespace App\Security\Voter;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Security;

class TaskVoter extends Voter
{
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    protected function supports($attribute, $subject)
    {
        return in_array($attribute, ['TASK_EDIT', 'TASK_VIEW'])
            && $subject instanceof \App\Entity\Task;
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();

        if (!$user instanceof UserInterface) {
            // the user must be logged in; if not, deny access
            return false;
        }

        switch ($attribute) {
            case 'TASK_DELETE':
                if ($user === $subject->getUsers()) {
                    return true;
                }
                if ($subject->getUsers()->getUsername() === "anonyme" && $this->security->isGranted('ROLE_ADMIN'))
                {
                    return true;
                }
                break;
            case 'TASK_VIEW':
                if($this->security->isGranted('ROLE_USER'))
                {
                    return true;
                }
                break;
        }

        return false;
    }
}
