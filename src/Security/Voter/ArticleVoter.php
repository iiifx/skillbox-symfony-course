<?php

namespace App\Security\Voter;

use App\Entity\Article;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;

class ArticleVoter extends Voter
{
    protected Security $security;

    /**
     * @required
     */
    public function setSecurity(Security $security): void
    {
        $this->security = $security;
    }

    protected function supports(string $attribute, $subject): bool
    {
        return $attribute === 'MANAGE' && $subject instanceof Article;
    }

    /**
     * @param Article $subject
     */
    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();

        if (!$user instanceof UserInterface) {
            return false;
        }

        if ($attribute === 'MANAGE') {
            if ($this->security->isGranted('ROLE_ADMIN_ARTICLE', $user)) {
                return true;
            }

            if ($user === $subject->getAuthor()) {
                return true;
            }
        }

        return false;
    }
}
