<?php

namespace Tests\AppBundle\Entity;

use AppBundle\Entity\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    public function testSetUsername()
    {
        $user = new User();

        $user->setUsername('Meli');

        $this->assertEquals('Meli', $user->getUsername());
    }

    public function testSetEmail()
    {
        $user = new User();

        $user->setEmail('meli@example.com');

        $this->assertEquals('meli@example.com', $user->getEmail());
    }

    public function testSetPassword()
    {
        $user = new User();

        $user->setPassword('azerty');

        $this->assertEquals('azerty', $user->getPassword());
    }

    public function testGetRoles()
    {
        $user = new User();
        $roles = ['ROLE_USER'];
        
        $this->assertEquals($roles, $user->getRoles());
    }
}
