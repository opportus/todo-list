<?php

namespace AppBundle\EventListener;

use AppBundle\Entity\AuthorableInterface;
use AppBundle\Entity\User;
use Symfony\Component\Form\FormEvent;

/**
 * The authorizer listener.
 *
 * @author Clément Cazaud <opportus@gmail.com>
 */
class AuthorizerListener
{
    /**
     * Authorizes the data on form submit.
     *
     * @param Symfony\Component\Form\FormEvent $event
     */
    public function onFormSubmit(FormEvent $event, User $user)
    {
        $authorable = $event->getData();

        if (!\is_object($authorable) || !$authorable instanceof AuthorableInterface) {
            return;
        }

        $accessMethod = $event->getForm()->getConfig()->getMethod();

        $authorableAccessMethods = ['POST'];

        if (!\in_array($accessMethod, $authorableAccessMethods)) {
            return;
        }

        if (null === $user) {
            return;
        }

        $authorable->setAuthor($user);
    }
}
