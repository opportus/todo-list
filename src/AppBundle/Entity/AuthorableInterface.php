<?php

namespace AppBundle\Entity;

use AppBundle\Entity\User;

/**
 * The authorable interface.
 *
 * @author Clément Cazaud <opportus@gmail.com>
 */
interface AuthorableInterface
{
    /**
     * Sets the author.
     *
     * @param User $author
     */
    public function setAuthor(User $author);

    /**
     * Gets the author.
     *
     * @return null|User
     */
    public function getAuthor(): ?User;
}
