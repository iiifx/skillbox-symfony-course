<?php

namespace App\Security\Voter;

use App\Entity\Article;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;

class ApiArticleVoter extends Voter
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
        return $attribute === 'API_ARTICLE' && $subject instanceof Article;
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

        if ($attribute === 'API_ARTICLE') {
            if ($this->security->isGranted('ROLE_API', $user)) {
                return true;
            }

            if ($user === $subject->getAuthor()) {
                return true;
            }
        }

        return false;
    }
}
