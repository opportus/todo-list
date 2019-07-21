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
     * @param FormEvent $event
     * @param null|User
     */
    public function onFormSubmit(FormEvent $event, ?User $user)
    {
        if (null === $user) {
            return;
        }

        $authorable = $event->getData();

        if (!\is_object($authorable) || !$authorable instanceof AuthorableInterface) {
            return;
        }

        $accessMethod = $event->getForm()->getConfig()->getMethod();

        $authorableAccessMethods = ['POST'];

        if (!\in_array($accessMethod, $authorableAccessMethods)) {
            return;
        }

        $authorable->setAuthor($user);
    }
}
