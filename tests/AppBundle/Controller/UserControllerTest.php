<?php

namespace Tests\AppBundle\Controller;

use Blackfire\Profile\Configuration as ProfileConfiguration;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class UserControllerTest extends WebTestCase
{
    use ControllerTestTrait;

    public function testGetUserList()
    {
        $blackfireClient = $this->createBlackfireClient();
        $httpClient = static::createClient();

        $profileConfiguration = (new ProfileConfiguration())->setTitle('get_user_list');
        $probe = $blackfireClient->createProbe($profileConfiguration);

        $crawler = $httpClient->request('GET', '/users');

        $profile = $blackfireClient->endProbe($probe);

        $this->assertEquals(Response::HTTP_OK, $httpClient->getResponse()->getStatusCode());
        $this->assertEquals('Liste des utilisateurs', $crawler->filter('.container h1')->text());
        $this->assertEquals('Meli', \trim($crawler->filter('table tbody tr')->eq(0)->filter('td')->eq(0)->text()));
        $this->assertEquals('meli@example.com', \trim($crawler->filter('table tbody tr')->eq(0)->filter('td')->eq(1)->text()));
        //$this->assertEquals('User', \trim($crawler->filter('table tbody tr')->eq(0)->filter('td')->eq(2)->text()));
        $this->assertEquals('Melo', \trim($crawler->filter('table tbody tr')->eq(1)->filter('td')->eq(0)->text()));
        $this->assertEquals('melo@example.com', \trim($crawler->filter('table tbody tr')->eq(1)->filter('td')->eq(1)->text()));
        //$this->assertEquals('User', \trim($crawler->filter('table tbody tr')->eq(1)->filter('td')->eq(2)->text()));

        $this->outputCost($profile, $profileConfiguration);
    }

    public function testGetCreateUser()
    {
        $blackfireClient = $this->createBlackfireClient();
        $httpClient = static::createClient();

        $profileConfiguration = (new ProfileConfiguration())->setTitle('get_create_user');
        $probe = $blackfireClient->createProbe($profileConfiguration);

        $crawler = $httpClient->request('GET', '/users/create');

        $profile = $blackfireClient->endProbe($probe);

        $this->assertEquals(Response::HTTP_OK, $httpClient->getResponse()->getStatusCode());
        $this->assertEquals('Créer un utilisateur', $crawler->filter('.container h1')->text());
        $this->assertEquals('Nom d\'utilisateur', $crawler->filter('form #user_username')->previousAll()->text());
        $this->assertEquals('', $crawler->filter('form #user_username')->attr('value'));
        $this->assertEquals('Mot de passe', $crawler->filter('form #user_password_first')->previousAll()->text());
        $this->assertEquals('', $crawler->filter('form #user_password_first')->attr('value'));
        $this->assertEquals('Tapez le mot de passe à nouveau', $crawler->filter('form #user_password_second')->previousAll()->text());
        $this->assertEquals('', $crawler->filter('form #user_password_second')->attr('value'));
        $this->assertEquals('Adresse email', $crawler->filter('form #user_email')->previousAll()->text());
        $this->assertEquals('', $crawler->filter('form #user_email')->attr('value'));
        //$this->assertEquals('Role', $crawler->filter('form #user_role')->previousAll()->text());
        //$this->assertEquals('', $crawler->filter('form #user_role')->attr('value'));

        $this->outputCost($profile, $profileConfiguration);
    }

    public function testPostCreateUser()
    {
        $blackfireClient = $this->createBlackfireClient();
        $httpClient = static::createClient();

        $crawler = $httpClient->request('GET', '/users/create');

        $form = $crawler->selectButton('Ajouter')->form([
            'user[username]' => 'Meli',
            'user[password][first]' => 'qwerty',
            'user[password][second]' => 'azerty',
            'user[email]' => 'meli@example.com',
            //'user[role]' => 'ROLE_USER',
        ]);

        $crawler = $httpClient->submit($form);

        //$this->assertEquals('This value is already used.', \trim($crawler->filter('#user_username')->nextAll()->text()));
        $this->assertEquals('Les deux mots de passe doivent correspondre.', \trim($crawler->filter('#user_password_first')->nextAll()->text()));
        $this->assertEquals('This value is already used.', \trim($crawler->filter('#user_email')->nextAll()->text()));

        $form['user[username]'] = 'Allo';
        $form['user[password][first]'] = 'azerty';
        $form['user[email]'] = 'allo@example.com';

        $profileConfiguration = (new ProfileConfiguration())->setTitle('post_create_user');
        $probe = $blackfireClient->createProbe($profileConfiguration);

        $crawler = $httpClient->submit($form);

        $profile = $blackfireClient->endProbe($probe);

        $this->assertEquals(Response::HTTP_FOUND, $httpClient->getResponse()->getStatusCode());

        $crawler = $httpClient->followRedirect();

        $this->assertEquals(Response::HTTP_OK, $httpClient->getResponse()->getStatusCode());
        $this->assertEquals('Superbe ! L\'utilisateur a bien été ajouté.', \trim($crawler->filter('.alert-success')->text()));
        $this->assertEquals('Liste des utilisateurs', $crawler->filter('.container h1')->text());
        $this->assertEquals('Allo', \trim($crawler->filter('table tbody tr')->last()->filter('td')->eq(0)->text()));
        $this->assertEquals('allo@example.com', \trim($crawler->filter('table tbody tr')->last()->filter('td')->eq(1)->text()));
        //$this->assertEquals('User', \trim($crawler->filter('table tbody tr')->last()->filter('td')->eq(2)->text()));

        $this->outputCost($profile, $profileConfiguration);
    }

    public function testGetEditUser()
    {
        $blackfireClient = $this->createBlackfireClient();
        $httpClient = static::createClient();

        $profileConfiguration = (new ProfileConfiguration())->setTitle('get_edit_user');
        $probe = $blackfireClient->createProbe($profileConfiguration);

        $crawler = $httpClient->request('GET', '/users/1/edit');

        $profile = $blackfireClient->endProbe($probe);

        $this->assertEquals(Response::HTTP_OK, $httpClient->getResponse()->getStatusCode());
        $this->assertEquals('Modifier Meli', $crawler->filter('.container h1')->text());
        $this->assertEquals('Nom d\'utilisateur', $crawler->filter('form #user_username')->previousAll()->text());
        $this->assertEquals('Meli', $crawler->filter('form #user_username')->attr('value'));
        $this->assertEquals('Mot de passe', $crawler->filter('form #user_password_first')->previousAll()->text());
        $this->assertEquals('', $crawler->filter('form #user_password_first')->attr('value'));
        $this->assertEquals('Tapez le mot de passe à nouveau', $crawler->filter('form #user_password_second')->previousAll()->text());
        $this->assertEquals('', $crawler->filter('form #user_password_second')->attr('value'));
        $this->assertEquals('Adresse email', $crawler->filter('form #user_email')->previousAll()->text());
        $this->assertEquals('meli@example.com', $crawler->filter('form #user_email')->attr('value'));
        //$this->assertEquals('Role', $crawler->filter('form #user_role')->previousAll()->text());
        //$this->assertEquals('ROLE_USER', $crawler->filter('form #user_role')->attr('value'));

        $this->outputCost($profile, $profileConfiguration);
    }

    public function testPostEditUser()
    {
        $blackfireClient = $this->createBlackfireClient();
        $httpClient = static::createClient();

        $crawler = $httpClient->request('GET', '/users/1/edit');

        $form = $crawler->selectButton('Modifier')->form([
            'user[username]' => 'Melo',
            'user[password][first]' => 'qwerty',
            'user[password][second]' => 'azerty',
            'user[email]' => 'melo@example.com',
            //'user[role]' => 'ROLE_USER',
        ]);

        $crawler = $httpClient->submit($form);

        //$this->assertEquals('This value is already used.', \trim($crawler->filter('#user_username')->nextAll()->text()));
        $this->assertEquals('Les deux mots de passe doivent correspondre.', \trim($crawler->filter('#user_password_first')->nextAll()->text()));
        $this->assertEquals('This value is already used.', \trim($crawler->filter('#user_email')->nextAll()->text()));

        $form['user[username]'] = 'Allo';
        $form['user[password][first]'] = 'azerty';
        $form['user[email]'] = 'allo@example.com';

        $profileConfiguration = (new ProfileConfiguration())->setTitle('post_edit_user');
        $probe = $blackfireClient->createProbe($profileConfiguration);

        $crawler = $httpClient->submit($form);

        $profile = $blackfireClient->endProbe($probe);

        $this->assertEquals(Response::HTTP_FOUND, $httpClient->getResponse()->getStatusCode());

        $crawler = $httpClient->followRedirect();

        $this->assertEquals(Response::HTTP_OK, $httpClient->getResponse()->getStatusCode());
        $this->assertEquals('Superbe ! L\'utilisateur a bien été modifié', \trim($crawler->filter('.alert-success')->text()));
        $this->assertEquals('Liste des utilisateurs', $crawler->filter('.container h1')->text());
        $this->assertEquals('Allo', \trim($crawler->filter('table tbody tr')->first()->filter('td')->eq(0)->text()));
        $this->assertEquals('allo@example.com', \trim($crawler->filter('table tbody tr')->first()->filter('td')->eq(1)->text()));
        //$this->assertEquals('User', \trim($crawler->filter('table tbody tr')->last()->filter('td')->eq(2)->text()));

        $this->outputCost($profile, $profileConfiguration);
    }
}
