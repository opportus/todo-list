<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    public function testGetHomepage()
    {
        $client = static::createClient([], ['PHP_AUTH_USER' => 'Meli', 'PHP_AUTH_PW' => 'azerty']);
        $crawler = $client->request('GET', '/');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        $this->assertContains('Bienvenue sur Todo List, l\'application vous permettant de gérer l\'ensemble de vos tâches sans effort !', $crawler->filter('.container h1')->text());
    }
}
