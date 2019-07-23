<?php

namespace Tests\AppBundle\Controller;

use AppBundle\Framework\Test\CostAwareWebTestCase;

class UserControllerPerfTest extends CostAwareWebTestCase
{
    use ControllerTestTrait;

    public function testGetUserList()
    {
        $testClient = $this->createTestClientWithAdminRole();

        $testClient->requestAndProfile('GET', '/users');
    }

    public function testGetCreateUser()
    {
        $testClient = $this->createTestClientWithAdminRole();

        $testClient->requestAndProfile('GET', '/users/create');
    }

    public function testPostCreateUserInvalid()
    {
        $testClient = $this->createTestClientWithAdminRole();

        $crawler = $testClient->request('GET', '/users/create');

        $form = $crawler->selectButton('Ajouter')->form([
            'user[username]' => 'Meli',
            'user[password][first]' => 'qwerty',
            'user[password][second]' => 'azerty',
            'user[email]' => 'meli@example.com',
            'user[role]' => 'ROLE_ADMIN',
        ]);

        $testClient->submitAndProfile($form);
    }

    public function testPostCreateUser()
    {
        $testClient = $this->createTestClientWithAdminRole();

        $crawler = $testClient->request('GET', '/users/create');

        $form = $crawler->selectButton('Ajouter')->form([
            'user[username]' => 'Allo',
            'user[password][first]' => 'azerty',
            'user[password][second]' => 'azerty',
            'user[email]' => 'allo@example.com',
            'user[role]' => 'ROLE_USER',
        ]);

        $testClient->submitAndProfile($form);
    }

    public function testGetEditUser()
    {
        $testClient = $this->createTestClientWithAdminRole();

        $testClient->requestAndProfile('GET', '/users/1/edit');
    }

    public function testPostEditUserException()
    {
        $testClient = $this->createTestClientWithAdminRole();

        $crawler = $testClient->request('GET', '/users/1/edit');

        $form = $crawler->selectButton('Modifier')->form([
            'user[username]' => 'Melo',
            'user[password][first]' => 'qwerty',
            'user[password][second]' => 'azerty',
            'user[email]' => 'melo@example.com',
            'user[role]' => 'ROLE_USER',
        ]);

        $testClient->submitAndProfile($form);
    }

    public function testPostEditUser()
    {
        $testClient = $this->createTestClientWithAdminRole();

        $crawler = $testClient->request('GET', '/users/1/edit');

        $form = $crawler->selectButton('Modifier')->form([
            'user[username]' => 'Allo',
            'user[password][first]' => 'azerty',
            'user[password][second]' => 'azerty',
            'user[email]' => 'allo@example.com',
            'user[role]' => 'ROLE_USER',
        ]);

        $testClient->submitAndProfile($form);
    }
}
