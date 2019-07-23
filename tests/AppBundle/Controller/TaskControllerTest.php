<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class TaskControllerTest extends WebTestCase
{
    use ControllerTestTrait;

    public function testGetTaskListUnauthenticated()
    {
        $testClient = $this->createUnauthenticatedTestClient();

        $testClient->request('GET', '/tasks');

        $this->assertEquals(Response::HTTP_FOUND, $testClient->getResponse()->getStatusCode());
    }

    public function testGetTaskListAuthenticated()
    {
        $testClient = $this->createAuthenticatedTestClient();

        $crawler = $testClient->request('GET', '/tasks');

        $this->assertEquals(Response::HTTP_OK, $testClient->getResponse()->getStatusCode());
        $this->assertEquals(2, $crawler->filter('.task')->count());
        $this->assertEquals('Lorem Ipsum', \trim($crawler->filter('.task')->eq(0)->filter('h4')->text()));
        $this->assertEquals('Lorem ipsum dolor sit amet consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', \trim($crawler->filter('.task')->eq(0)->filter('p')->text()));
        $this->assertEquals('Auteur: Meli', \trim($crawler->filter('.task')->eq(0)->filter('.author')->text()));
        $this->assertEquals('glyphicon glyphicon-remove', \trim($crawler->filter('.task')->eq(0)->filter('.status span')->attr('class')));
        $this->assertEquals('Lorem Ipsum', \trim($crawler->filter('.task')->eq(1)->filter('h4')->text()));
        $this->assertEquals('Lorem ipsum dolor sit amet consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', \trim($crawler->filter('.task')->eq(1)->filter('p')->text()));
        $this->assertEquals('glyphicon glyphicon-remove', \trim($crawler->filter('.task')->eq(1)->filter('.status span')->attr('class')));
        $this->assertEquals('Auteur: Melo', \trim($crawler->filter('.task')->eq(1)->filter('.author')->text()));
    }

    public function testGetCreateTaskUnauthenticated()
    {
        $testClient = $this->createUnauthenticatedTestClient();

        $testClient->request('GET', '/tasks/create');

        $this->assertEquals(Response::HTTP_FOUND, $testClient->getResponse()->getStatusCode());
    }

    public function testGetCreateTaskAuthenticated()
    {
        $testClient = $this->createAuthenticatedTestClient();

        $crawler = $testClient->request('GET', '/tasks/create');

        $this->assertEquals(Response::HTTP_OK, $testClient->getResponse()->getStatusCode());
        $this->assertEquals('Title', $crawler->filter('form #task_title')->previousAll()->text());
        $this->assertEquals('', $crawler->filter('form #task_title')->attr('value'));
        $this->assertEquals('Content', $crawler->filter('form #task_content')->previousAll()->text());
        $this->assertEquals('', $crawler->filter('form #task_content')->text());
    }

    public function testPostCreateTaskUnauthenticated()
    {
        $testClient = $this->createAuthenticatedTestClient();

        $crawler = $testClient->request('GET', '/tasks/create');

        $form = $crawler->selectButton('Ajouter')->form();

        $testClient = $this->createUnauthenticatedTestClient();

        $crawler = $testClient->submit($form);

        $this->assertEquals(Response::HTTP_FOUND, $testClient->getResponse()->getStatusCode());
    }

    public function testPostCreateTaskAuthenticated()
    {
        $testClient = $this->createAuthenticatedTestClient();

        $crawler = $testClient->request('GET', '/tasks/create');

        $form = $crawler->selectButton('Ajouter')->form([
            'task[title]' => 'Test Task',
            'task[content]' => 'This is a test task.',
        ]);

        $crawler = $testClient->submit($form);

        $this->assertEquals(Response::HTTP_FOUND, $testClient->getResponse()->getStatusCode());

        $crawler = $testClient->followRedirect();

        $this->assertEquals(Response::HTTP_OK, $testClient->getResponse()->getStatusCode());
        $this->assertEquals('Superbe ! La tâche a été bien été ajoutée.', \trim($crawler->filter('.alert-success')->text()));
        $this->assertEquals('Test Task', \trim($crawler->filter('.task')->last()->filter('h4')->text()));
        $this->assertEquals('This is a test task.', \trim($crawler->filter('.task')->last()->filter('p')->text()));
        $this->assertEquals('glyphicon glyphicon-remove', \trim($crawler->filter('.task')->last()->filter('.status span')->attr('class')));
        $this->assertEquals('Auteur: Meli', \trim($crawler->filter('.task')->last()->filter('.author')->text()));
    }

    public function testGetEditTaskUnauthenticated()
    {
        $testClient = $this->createUnauthenticatedTestClient();

        $testClient->request('GET', '/tasks/1/edit');

        $this->assertEquals(Response::HTTP_FOUND, $testClient->getResponse()->getStatusCode());
    }

    public function testGetEditTaskAuthenticated()
    {
        $testClient = $this->createAuthenticatedTestClient();

        $crawler = $testClient->request('GET', '/tasks/1/edit');

        $this->assertEquals(Response::HTTP_OK, $testClient->getResponse()->getStatusCode());
        $this->assertEquals('Title', $crawler->filter('form #task_title')->previousAll()->text());
        $this->assertEquals('Lorem Ipsum', $crawler->filter('form #task_title')->attr('value'));
        $this->assertEquals('Content', $crawler->filter('form #task_content')->previousAll()->text());
        $this->assertEquals('Lorem ipsum dolor sit amet consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', $crawler->filter('form #task_content')->text());
    }

    public function testPostEditTaskUnauthenticated()
    {
        $testClient = $this->createAuthenticatedTestClient();

        $crawler = $testClient->request('GET', '/tasks/1/edit');

        $form = $crawler->selectButton('Modifier')->form();

        $testClient = $this->createUnauthenticatedTestClient();

        $crawler = $testClient->submit($form);

        $this->assertEquals(Response::HTTP_FOUND, $testClient->getResponse()->getStatusCode());
    }

    public function testPostEditTaskAuthenticated()
    {
        $testClient = $this->createAuthenticatedTestClient();

        $crawler = $testClient->request('GET', '/tasks/1/edit');

        $form = $crawler->selectButton('Modifier')->form([
            'task[title]' => 'Updated Test Task',
            'task[content]' => 'This is an updated test task.',
        ]);

        $crawler = $testClient->submit($form);

        $this->assertEquals(Response::HTTP_FOUND, $testClient->getResponse()->getStatusCode());

        $crawler = $testClient->followRedirect();

        $this->assertEquals(Response::HTTP_OK, $testClient->getResponse()->getStatusCode());
        $this->assertEquals('Superbe ! La tâche a bien été modifiée.', \trim($crawler->filter('.alert-success')->text()));
        $this->assertEquals('Updated Test Task', \trim($crawler->filter('.task')->eq(0)->filter('h4')->text()));
        $this->assertEquals('This is an updated test task.', \trim($crawler->filter('.task')->eq(0)->filter('p')->text()));
        $this->assertEquals('glyphicon glyphicon-remove', \trim($crawler->filter('.task')->eq(0)->filter('.status span')->attr('class')));
        $this->assertEquals('Auteur: Meli', \trim($crawler->filter('.task')->eq(0)->filter('.author')->text()));
    }

    public function testPostToggleTaskUnauthenticated()
    {
        $testClient = $this->createUnauthenticatedTestClient();

        $testClient->request('POST', '/tasks/1/toggle');

        $this->assertEquals(Response::HTTP_FOUND, $testClient->getResponse()->getStatusCode());
    }

    public function testPostToggleTaskAuthenticated()
    {
        $testClient = $this->createAuthenticatedTestClient();

        $crawler = $testClient->request('POST', '/tasks/1/toggle');

        $this->assertEquals(Response::HTTP_FOUND, $testClient->getResponse()->getStatusCode());

        $crawler = $testClient->followRedirect();

        $this->assertEquals(Response::HTTP_OK, $testClient->getResponse()->getStatusCode());
        $this->assertEquals('Superbe ! La tâche Lorem Ipsum a bien été marquée comme faite.', \trim($crawler->filter('.alert-success')->text()));
        $this->assertEquals('Lorem Ipsum', \trim($crawler->filter('.task')->eq(0)->filter('h4')->text()));
        $this->assertEquals('Lorem ipsum dolor sit amet consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', \trim($crawler->filter('.task')->eq(0)->filter('p')->text()));
        $this->assertEquals('glyphicon glyphicon-ok', \trim($crawler->filter('.task')->eq(0)->filter('.status span')->attr('class')));
        $this->assertEquals('Auteur: Meli', \trim($crawler->filter('.task')->eq(0)->filter('.author')->text()));
    }

    public function testPostDeleteTaskUnautenticated()
    {
        $testClient = $this->createUnauthenticatedTestClient();

        $testClient->request('POST', '/tasks/1/delete');

        $this->assertEquals(Response::HTTP_FOUND, $testClient->getResponse()->getStatusCode());
    }

    public function testPostDeleteTaskAuthenticated()
    {
        $testClient = $this->createAuthenticatedTestClient();

        $crawler = $testClient->request('POST', '/tasks/1/delete');

        $this->assertEquals(Response::HTTP_FOUND, $testClient->getResponse()->getStatusCode());

        $crawler = $testClient->followRedirect();

        $this->assertEquals(Response::HTTP_OK, $testClient->getResponse()->getStatusCode());
        $this->assertEquals('Superbe ! La tâche a bien été supprimée.', \trim($crawler->filter('.alert-success')->text()));
        $this->assertEquals(1, $crawler->filter('.task')->count());
    }
}
