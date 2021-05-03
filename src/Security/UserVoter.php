<?php

namespace App\Security;

use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class UserVoter extends Voter
{
const VIEW = 'view';
const EDIT = 'edit';

protected function supports($attribute, $subject): bool
{
// if the attribute isn't one we support, return false
if (!in_array($attribute, [self::VIEW, self::EDIT])) {
return false;
}

// only vote on `Post` objects
if (!$subject instanceof Post) {
return false;
}

return true;
}

protected function voteOnAttribute($attribute, $subject, TokenInterface $token): bool
{
    $user = $token->getUser();

    if (!$user instanceof User) {
        // the user must be logged in; if not, deny access
        return false;
    }

    // you know $subject is a Post object, thanks to `supports()`
    /** @var Post $post */
    $post = $subject;

    switch ($attribute) {
        case self::VIEW:
            return $this->canView($post, $user);
        case self::EDIT:
            return $this->canEdit($post, $user);
    }

    throw new \LogicException('This code should not be reached!');
}

    private function canView(Post $post, User $user): bool
    {
        // if they can edit, they can view
        if ($this->canEdit($post, $user)) {
            return true;
        }

        // the Post object could have, for example, a method `isPrivate()`
        return !$post->isPrivate();
    }
    private function canEdit(Post $post, User $user): bool
    {
        // this assumes that the Post object has a `getOwner()` method
        return $user === $post->getOwner();
    }
}