<?php

namespace Tests\AppBundle\Controller;

use Blackfire\Profile\Configuration as ProfileConfiguration;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class DefaultControllerTest extends WebTestCase
{
    use ControllerTestTrait;

    public function testGetHomepage()
    {
        $httpClient = static::createClient();

        $crawler = $httpClient->request('GET', '/');

        $this->assertEquals(Response::HTTP_FOUND, $httpClient->getResponse()->getStatusCode());

        $blackfireClient = $this->createBlackfireClient();
        $httpClient = static::createClient([], [
            'PHP_AUTH_USER' => 'Meli',
            'PHP_AUTH_PW' => 'azerty',
        ]);

        $profileConfiguration = (new ProfileConfiguration())->setTitle('get_homepage');
        $probe = $blackfireClient->createProbe($profileConfiguration);

        $crawler = $httpClient->request('GET', '/');

        $profile = $blackfireClient->endProbe($probe);

        $this->assertEquals(Response::HTTP_OK, $httpClient->getResponse()->getStatusCode());
        $this->assertEquals('Bienvenue sur Todo List, l\'application vous permettant de gérer l\'ensemble de vos tâches sans effort !', $crawler->filter('.container h1')->text());

        $this->outputCost($profile, $profileConfiguration);
    }
}
