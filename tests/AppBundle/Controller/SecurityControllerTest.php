<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class SecurityControllerTest extends WebTestCase
{
    use ControllerTestTrait;

    public function testGetLogin()
    {
        $testClient = $this->createUnauthenticatedTestClient();

        $testClient->request('GET', '/login');

        $this->assertEquals(Response::HTTP_OK, $testClient->getResponse()->getStatusCode());
    }

    public function testPostLoginValid()
    {
        $testClient = $this->createUnauthenticatedTestClient();

        $crawler = $testClient->request('GET', '/login');

        $form = $crawler->selectButton('Se connecter')->form([
            '_username' => 'Meli',
            '_password' => 'azerty',
        ]);

        $testClient->submit($form);

        $this->AssertEquals(Response::HTTP_FOUND, $testClient->getResponse()->getStatusCode());

        $crawler = $testClient->followRedirect();

        $this->assertEquals('Bienvenue sur Todo List, l\'application vous permettant de gérer l\'ensemble de vos tâches sans effort !', \trim($crawler->filter('.container h1')->text()));
    }

    public function testPostLoginInvalid()
    {
        $testClient = $this->createUnauthenticatedTestClient();

        $crawler = $testClient->request('GET', '/login');

        $form = $crawler->selectButton('Se connecter')->form([
            '_username' => 'Meli Melo',
            '_password' => '',
        ]);

        $testClient->submit($form);

        $this->AssertEquals(Response::HTTP_FOUND, $testClient->getResponse()->getStatusCode());

        $crawler = $testClient->followRedirect();

        $this->assertEquals('Invalid credentials.', \trim($crawler->filter('.container div .alert')->text()));
    }
}
