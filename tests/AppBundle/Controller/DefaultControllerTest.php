<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class DefaultControllerTest extends WebTestCase
{
    use ControllerTestTrait;

    public function testGetHomepageWithNoRole()
    {
        $testClient = $this->createTestClientWithNoRole();

        $testClient->request('GET', '/');

        $this->assertEquals(Response::HTTP_FOUND, $testClient->getResponse()->getStatusCode());
    }

    public function testGetHomepageWithUserRole()
    {
        $testClient = $this->createTestClientWithUserRole();

        $crawler = $testClient->request('GET', '/');

        $this->assertEquals(Response::HTTP_OK, $testClient->getResponse()->getStatusCode());
        $this->assertEquals('Bienvenue sur Todo List, l\'application vous permettant de gérer l\'ensemble de vos tâches sans effort !', $crawler->filter('.container h1')->text());
    }
}
