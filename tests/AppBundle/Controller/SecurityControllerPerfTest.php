<?php

namespace Tests\AppBundle\Controller;

use AppBundle\Framework\Test\CostAwareWebTestCase;

class SecurityControllerPerfTest extends CostAwareWebTestCase
{
    use ControllerTestTrait;

    public function testGetLogin()
    {
        $testClient = $this->createTestClientWithNoRole();

        $testClient->requestAndProfile('GET', '/login');
    }

    public function testPostLogin()
    {
        $testClient = $this->createTestClientWithNoRole();

        $crawler = $testClient->request('GET', '/login');

        $form = $crawler->selectButton('Se connecter')->form([
            '_username' => 'Meli',
            '_password' => 'azerty',
        ]);

        $testClient->submitAndProfile($form);
    }

    public function testPostLoginException()
    {
        $testClient = $this->createTestClientWithNoRole();

        $crawler = $testClient->request('GET', '/login');

        $form = $crawler->selectButton('Se connecter')->form([
            '_username' => 'Meli Melo',
            '_password' => '',
        ]);

        $testClient->submitAndProfile($form);
    }
}
