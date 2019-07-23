<?php

namespace AppBundle\Security;

use AppBundle\Entity\Task;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

/**
 * The task voter.
 *
 * @package AppBundle\Security
 * @author Clément Cazaud <opportus@gmail.com>
 */
final class TaskVoter extends Voter
{
    /**
     * {@inheritDoc}
     */
    protected function supports($attribute, $subject)
    {
        return $subject instanceof Task && 'DELETE' === $attribute;
    }

    /**
     * {@inheritDoc}
     */
    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        switch ($attribute) {
            case 'DELETE':
                return $token->getUser()->getUsername() === $subject->getAuthor()->getUsername();
        }
    }
}
