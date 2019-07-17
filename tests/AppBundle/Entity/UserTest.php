<?php

namespace Tests\AppBundle\Entity;

use AppBundle\Entity\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    public function testConstruct()
    {
        $user = new User();
        
        $this->assertEquals([User::ROLE_USER], $user->getRoles());
    }

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

    public function testSetRole()
    {
        $user = new User();

        $user->setRole(User::ROLE_USER);

        $this->AssertEquals([User::ROLE_USER], $user->getRoles());
        $this->AssertEquals('Utilisateur', $user->getRole());

        $user->setRole(User::ROLE_ADMIN);

        $this->assertEquals([User::ROLE_USER, User::ROLE_ADMIN], $user->getRoles());
        $this->assertEquals('Administrateur', $user->getRole());
    }
}
