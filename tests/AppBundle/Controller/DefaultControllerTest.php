<?php

namespace Tests\AppBundle\Controller;

use AppBundle\Framework\Test\CostAwareWebTestCase;
use Symfony\Component\HttpFoundation\Response;

class DefaultControllerTest extends CostAwareWebTestCase
{
    use ControllerTestTrait;

    public function testGetHomepageUnauthenticated()
    {
        $testClient = $this->createUnauthenticatedTestClient();

        $testClient->request('GET', '/');

        $this->assertEquals(Response::HTTP_FOUND, $testClient->getResponse()->getStatusCode());
    }

    public function testGetHomepageAuthenticated()
    {
        $testClient = $this->createAuthenticatedTestClient();

        $crawler = $testClient->request('GET', '/');

        $this->assertEquals(Response::HTTP_OK, $testClient->getResponse()->getStatusCode());
        $this->assertEquals('Bienvenue sur Todo List, l\'application vous permettant de gérer l\'ensemble de vos tâches sans effort !', $crawler->filter('.container h1')->text());
    }
}
