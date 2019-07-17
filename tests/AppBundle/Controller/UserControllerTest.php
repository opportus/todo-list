<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class UserControllerTest extends WebTestCase
{
    use ControllerTestTrait;

    public function testGetUserList()
    {
        $testClient = $this->createUnauthenticatedTestClient();

        $crawler = $testClient->request('GET', '/users');

        $this->assertEquals(Response::HTTP_OK, $testClient->getResponse()->getStatusCode());
        $this->assertEquals('Liste des utilisateurs', $crawler->filter('.container h1')->text());
        $this->assertEquals('Meli', \trim($crawler->filter('table tbody tr')->eq(0)->filter('td')->eq(0)->text()));
        $this->assertEquals('meli@example.com', \trim($crawler->filter('table tbody tr')->eq(0)->filter('td')->eq(1)->text()));
        $this->assertEquals('Administrateur', \trim($crawler->filter('table tbody tr')->eq(0)->filter('td')->eq(2)->text()));
        $this->assertEquals('Melo', \trim($crawler->filter('table tbody tr')->eq(1)->filter('td')->eq(0)->text()));
        $this->assertEquals('melo@example.com', \trim($crawler->filter('table tbody tr')->eq(1)->filter('td')->eq(1)->text()));
        $this->assertEquals('Utilisateur', \trim($crawler->filter('table tbody tr')->eq(1)->filter('td')->eq(2)->text()));
    }

    public function testGetCreateUser()
    {
        $testClient = $this->createUnauthenticatedTestClient();

        $crawler = $testClient->request('GET', '/users/create');

        $this->assertEquals(Response::HTTP_OK, $testClient->getResponse()->getStatusCode());
        $this->assertEquals('Créer un utilisateur', $crawler->filter('.container h1')->text());
        $this->assertEquals('Nom d\'utilisateur', $crawler->filter('form #user_username')->previousAll()->text());
        $this->assertEquals('', $crawler->filter('form #user_username')->attr('value'));
        $this->assertEquals('Mot de passe', $crawler->filter('form #user_password_first')->previousAll()->text());
        $this->assertEquals('', $crawler->filter('form #user_password_first')->attr('value'));
        $this->assertEquals('Tapez le mot de passe à nouveau', $crawler->filter('form #user_password_second')->previousAll()->text());
        $this->assertEquals('', $crawler->filter('form #user_password_second')->attr('value'));
        $this->assertEquals('Adresse email', $crawler->filter('form #user_email')->previousAll()->text());
        $this->assertEquals('', $crawler->filter('form #user_email')->attr('value'));
        $this->assertEquals('Role', $crawler->filter('form #user_role')->previousAll()->text());
        $this->assertEquals('', $crawler->filter('form #user_role')->first()->text('value'));
    }

    public function testPostCreateUserInvalid()
    {
        $testClient = $this->createUnauthenticatedTestClient();

        $crawler = $testClient->request('GET', '/users/create');

        $form = $crawler->selectButton('Ajouter')->form([
            'user[username]' => 'Meli',
            'user[password][first]' => 'qwerty',
            'user[password][second]' => 'azerty',
            'user[email]' => 'meli@example.com',
            'user[role]' => 'ROLE_ADMIN',
        ]);

        $crawler = $testClient->submit($form);

        $this->assertEquals('This value is already used.', \trim($crawler->filter('#user_username')->nextAll()->text()));
        $this->assertEquals('Les deux mots de passe doivent correspondre.', \trim($crawler->filter('#user_password_first')->nextAll()->text()));
        $this->assertEquals('This value is already used.', \trim($crawler->filter('#user_email')->nextAll()->text()));
    }

    public function testPostCreateUserValid()
    {
        $testClient = $this->createUnauthenticatedTestClient();

        $crawler = $testClient->request('GET', '/users/create');

        $form = $crawler->selectButton('Ajouter')->form([
            'user[username]' => 'Allo',
            'user[password][first]' => 'azerty',
            'user[password][second]' => 'azerty',
            'user[email]' => 'allo@example.com',
            'user[role]' => 'ROLE_USER',
        ]);

        $crawler = $testClient->submit($form);

        $this->assertEquals(Response::HTTP_FOUND, $testClient->getResponse()->getStatusCode());

        $crawler = $testClient->followRedirect();

        $this->assertEquals(Response::HTTP_OK, $testClient->getResponse()->getStatusCode());
        $this->assertEquals('Superbe ! L\'utilisateur a bien été ajouté.', \trim($crawler->filter('.alert-success')->text()));
        $this->assertEquals('Liste des utilisateurs', $crawler->filter('.container h1')->text());
        $this->assertEquals('Allo', \trim($crawler->filter('table tbody tr')->last()->filter('td')->eq(0)->text()));
        $this->assertEquals('allo@example.com', \trim($crawler->filter('table tbody tr')->last()->filter('td')->eq(1)->text()));
        $this->assertEquals('Utilisateur', \trim($crawler->filter('table tbody tr')->last()->filter('td')->eq(2)->text()));
    }

    public function testGetEditUser()
    {
        $testClient = $this->createUnauthenticatedTestClient();

        $crawler = $testClient->request('GET', '/users/1/edit');

        $this->assertEquals(Response::HTTP_OK, $testClient->getResponse()->getStatusCode());
        $this->assertEquals('Modifier Meli', $crawler->filter('.container h1')->text());
        $this->assertEquals('Nom d\'utilisateur', $crawler->filter('form #user_username')->previousAll()->text());
        $this->assertEquals('Meli', $crawler->filter('form #user_username')->attr('value'));
        $this->assertEquals('Mot de passe', $crawler->filter('form #user_password_first')->previousAll()->text());
        $this->assertEquals('', $crawler->filter('form #user_password_first')->attr('value'));
        $this->assertEquals('Tapez le mot de passe à nouveau', $crawler->filter('form #user_password_second')->previousAll()->text());
        $this->assertEquals('', $crawler->filter('form #user_password_second')->attr('value'));
        $this->assertEquals('Adresse email', $crawler->filter('form #user_email')->previousAll()->text());
        $this->assertEquals('meli@example.com', $crawler->filter('form #user_email')->attr('value'));
        $this->assertEquals('Role', $crawler->filter('form #user_role')->previousAll()->text());
        $this->assertEquals('Administrateur', $crawler->filter('form #user_role')->first()->text());
    }

    public function testPostEditUserInvalid()
    {
        $testClient = $this->createUnauthenticatedTestClient();

        $crawler = $testClient->request('GET', '/users/1/edit');

        $form = $crawler->selectButton('Modifier')->form([
            'user[username]' => 'Melo',
            'user[password][first]' => 'qwerty',
            'user[password][second]' => 'azerty',
            'user[email]' => 'melo@example.com',
            'user[role]' => 'ROLE_USER',
        ]);

        $crawler = $testClient->submit($form);

        $this->assertEquals('This value is already used.', \trim($crawler->filter('#user_username')->nextAll()->text()));
        $this->assertEquals('Les deux mots de passe doivent correspondre.', \trim($crawler->filter('#user_password_first')->nextAll()->text()));
        $this->assertEquals('This value is already used.', \trim($crawler->filter('#user_email')->nextAll()->text()));
    }

    public function testPostEditUserValid()
    {
        $testClient = $this->createUnauthenticatedTestClient();

        $crawler = $testClient->request('GET', '/users/1/edit');

        $form = $crawler->selectButton('Modifier')->form([
            'user[username]' => 'Allo',
            'user[password][first]' => 'azerty',
            'user[password][second]' => 'azerty',
            'user[email]' => 'allo@example.com',
            'user[role]' => 'ROLE_USER',
        ]);

        $crawler = $testClient->submit($form);

        $this->assertEquals(Response::HTTP_FOUND, $testClient->getResponse()->getStatusCode());

        $crawler = $testClient->followRedirect();

        $this->assertEquals(Response::HTTP_OK, $testClient->getResponse()->getStatusCode());
        $this->assertEquals('Superbe ! L\'utilisateur a bien été modifié', \trim($crawler->filter('.alert-success')->text()));
        $this->assertEquals('Liste des utilisateurs', $crawler->filter('.container h1')->text());
        $this->assertEquals('Allo', \trim($crawler->filter('table tbody tr')->first()->filter('td')->eq(0)->text()));
        $this->assertEquals('allo@example.com', \trim($crawler->filter('table tbody tr')->first()->filter('td')->eq(1)->text()));
        $this->assertEquals('Utilisateur', \trim($crawler->filter('table tbody tr')->last()->filter('td')->eq(2)->text()));
    }
}
