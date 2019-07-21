<?php

namespace Tests\AppBundle\Controller;

use AppBundle\Framework\Test\CostAwareWebTestCase;

class SecurityControllerPerfTest extends CostAwareWebTestCase
{
    use ControllerTestTrait;

    public function testGetLogin()
    {
        $testClient = $this->createUnauthenticatedTestClient();

        $testClient->requestAndProfile('GET', '/login');

        $testClient->outputCost();
    }

    public function testPostLoginValid()
    {
        $testClient = $this->createUnauthenticatedTestClient();

        $crawler = $testClient->request('GET', '/login');

        $form = $crawler->selectButton('Se connecter')->form([
            '_username' => 'Meli',
            '_password' => 'azerty',
        ]);

        $testClient->submitAndProfile($form);

        $testClient->outputCost();
    }

    public function testPostLoginInvalid()
    {
        $testClient = $this->createUnauthenticatedTestClient();

        $crawler = $testClient->request('GET', '/login');

        $form = $crawler->selectButton('Se connecter')->form([
            '_username' => 'Meli Melo',
            '_password' => '',
        ]);

        $testClient->submitAndProfile($form);

        $testClient->outputCost();
    }
}
