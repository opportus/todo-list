<?php

namespace Tests\AppBundle\Controller;

use Blackfire\Profile\Configuration as ProfileConfiguration;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class TaskControllerTest extends WebTestCase
{
    use ControllerTestTrait;

    public function testGetTaskList()
    {
        $httpClient = static::createClient();

        $crawler = $httpClient->request('GET', '/tasks');

        $this->assertEquals(Response::HTTP_FOUND, $httpClient->getResponse()->getStatusCode());

        $blackfireClient = $this->createBlackfireClient();
        $httpClient = static::createClient([], [
            'PHP_AUTH_USER' => 'Meli',
            'PHP_AUTH_PW' => 'azerty',
        ]);

        $profileConfiguration = (new ProfileConfiguration())->setTitle('get_task_list');
        $probe = $blackfireClient->createProbe($profileConfiguration);

        $crawler = $httpClient->request('GET', '/tasks');

        $profile = $blackfireClient->endProbe($probe);

        $this->assertEquals(Response::HTTP_OK, $httpClient->getResponse()->getStatusCode());
        $this->assertEquals(2, $crawler->filter('.task')->count());
        $this->assertEquals('Lorem Ipsum', \trim($crawler->filter('.task')->eq(0)->filter('h4')->text()));
        $this->assertEquals('Lorem ipsum dolor sit amet consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', \trim($crawler->filter('.task')->eq(0)->filter('p')->text()));
        $this->assertEquals('glyphicon glyphicon-remove', \trim($crawler->filter('.task')->eq(0)->filter('.status span')->attr('class')));
        $this->assertEquals('Lorem Ipsum', \trim($crawler->filter('.task')->eq(1)->filter('h4')->text()));
        $this->assertEquals('Lorem ipsum dolor sit amet consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', \trim($crawler->filter('.task')->eq(1)->filter('p')->text()));
        $this->assertEquals('glyphicon glyphicon-remove', \trim($crawler->filter('.task')->eq(1)->filter('.status span')->attr('class')));

        $this->outputCost($profile, $profileConfiguration);
    }

    public function testGetCreateTask()
    {
        $httpClient = static::createClient();

        $crawler = $httpClient->request('GET', '/tasks/create');

        $this->assertEquals(Response::HTTP_FOUND, $httpClient->getResponse()->getStatusCode());

        $blackfireClient = $this->createBlackfireClient();
        $httpClient = static::createClient([], [
            'PHP_AUTH_USER' => 'Meli',
            'PHP_AUTH_PW' => 'azerty',
        ]);

        $profileConfiguration = (new ProfileConfiguration())->setTitle('get_create_task');
        $probe = $blackfireClient->createProbe($profileConfiguration);

        $crawler = $httpClient->request('GET', '/tasks/create');

        $profile = $blackfireClient->endProbe($probe);

        $this->assertEquals(Response::HTTP_OK, $httpClient->getResponse()->getStatusCode());
        $this->assertEquals('Title', $crawler->filter('form #task_title')->previousAll()->text());
        $this->assertEquals('', $crawler->filter('form #task_title')->attr('value'));
        $this->assertEquals('Content', $crawler->filter('form #task_content')->previousAll()->text());
        $this->assertEquals('', $crawler->filter('form #task_content')->text());

        $this->outputCost($profile, $profileConfiguration);
    }

    public function testPostCreateTask()
    {
        $httpClient = static::createClient([], [
            'PHP_AUTH_USER' => 'Meli',
            'PHP_AUTH_PW' => 'azerty',
        ]);

        $crawler = $httpClient->request('GET', '/tasks/create');

        $form = $crawler->selectButton('Ajouter')->form();

        $httpClient = static::createClient();

        $crawler = $httpClient->submit($form);

        $this->assertEquals(Response::HTTP_FOUND, $httpClient->getResponse()->getStatusCode());

        $blackfireClient = $this->createBlackfireClient();
        $httpClient = static::createClient([], [
            'PHP_AUTH_USER' => 'Meli',
            'PHP_AUTH_PW' => 'azerty',
        ]);

        $crawler = $httpClient->request('GET', '/tasks/create');

        $form = $crawler->selectButton('Ajouter')->form([
            'task[title]' => 'Test Task',
            'task[content]' => 'This is a test task.',
        ]);

        $profileConfiguration = (new ProfileConfiguration())->setTitle('post_create_task');
        $probe = $blackfireClient->createProbe($profileConfiguration);

        $crawler = $httpClient->submit($form);

        $profile = $blackfireClient->endProbe($probe);

        $this->assertEquals(Response::HTTP_FOUND, $httpClient->getResponse()->getStatusCode());

        $crawler = $httpClient->followRedirect();

        $this->assertEquals(Response::HTTP_OK, $httpClient->getResponse()->getStatusCode());
        $this->assertEquals('Superbe ! La tâche a été bien été ajoutée.', \trim($crawler->filter('.alert-success')->text()));
        $this->assertEquals('Test Task', \trim($crawler->filter('.task')->last()->filter('h4')->text()));
        $this->assertEquals('This is a test task.', \trim($crawler->filter('.task')->last()->filter('p')->text()));
        $this->assertEquals('glyphicon glyphicon-remove', \trim($crawler->filter('.task')->eq(0)->filter('.status span')->attr('class')));
        //$this->assertEquals('Meli', \trim($crawler->filter('.task')->last()->filter('.author')->text()));

        $this->outputCost($profile, $profileConfiguration);
    }

    public function testGetEditTask()
    {
        $httpClient = static::createClient();

        $crawler = $httpClient->request('GET', '/tasks/1/edit');

        $this->assertEquals(Response::HTTP_FOUND, $httpClient->getResponse()->getStatusCode());

        $blackfireClient = $this->createBlackfireClient();
        $httpClient = static::createClient([], [
            'PHP_AUTH_USER' => 'Meli',
            'PHP_AUTH_PW' => 'azerty',
        ]);

        $profileConfiguration = (new ProfileConfiguration())->setTitle('get_edit_task');
        $probe = $blackfireClient->createProbe($profileConfiguration);

        $crawler = $httpClient->request('GET', '/tasks/1/edit');

        $profile = $blackfireClient->endProbe($probe);

        $this->assertEquals(Response::HTTP_OK, $httpClient->getResponse()->getStatusCode());
        $this->assertEquals('Title', $crawler->filter('form #task_title')->previousAll()->text());
        $this->assertEquals('Lorem Ipsum', $crawler->filter('form #task_title')->attr('value'));
        $this->assertEquals('Content', $crawler->filter('form #task_content')->previousAll()->text());
        $this->assertEquals('Lorem ipsum dolor sit amet consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', $crawler->filter('form #task_content')->text());

        $this->outputCost($profile, $profileConfiguration);
    }

    public function testPostEditTask()
    {
        $httpClient = static::createClient([], [
            'PHP_AUTH_USER' => 'Meli',
            'PHP_AUTH_PW' => 'azerty',
        ]);

        $crawler = $httpClient->request('GET', '/tasks/1/edit');

        $form = $crawler->selectButton('Modifier')->form();

        $httpClient = static::createClient();

        $crawler = $httpClient->submit($form);

        $this->assertEquals(Response::HTTP_FOUND, $httpClient->getResponse()->getStatusCode());

        $blackfireClient = $this->createBlackfireClient();
        $httpClient = static::createClient([], [
            'PHP_AUTH_USER' => 'Meli',
            'PHP_AUTH_PW' => 'azerty',
        ]);

        $crawler = $httpClient->request('GET', '/tasks/1/edit');

        $form = $crawler->selectButton('Modifier')->form([
            'task[title]' => 'Updated Test Task',
            'task[content]' => 'This is an updated test task.',
        ]);

        $profileConfiguration = (new ProfileConfiguration())->setTitle('post_edit_task');
        $probe = $blackfireClient->createProbe($profileConfiguration);

        $crawler = $httpClient->submit($form);

        $profile = $blackfireClient->endProbe($probe);

        $this->assertEquals(Response::HTTP_FOUND, $httpClient->getResponse()->getStatusCode());

        $crawler = $httpClient->followRedirect();

        $this->assertEquals(Response::HTTP_OK, $httpClient->getResponse()->getStatusCode());
        $this->assertEquals('Superbe ! La tâche a bien été modifiée.', \trim($crawler->filter('.alert-success')->text()));
        $this->assertEquals('Updated Test Task', \trim($crawler->filter('.task')->eq(0)->filter('h4')->text()));
        $this->assertEquals('This is an updated test task.', \trim($crawler->filter('.task')->eq(0)->filter('p')->text()));
        $this->assertEquals('glyphicon glyphicon-remove', \trim($crawler->filter('.task')->eq(0)->filter('.status span')->attr('class')));
        //$this->assertEquals('Meli', \trim($crawler->filter('.task')->eq(0)->filter('.author')->text()));

        $this->outputCost($profile, $profileConfiguration);
    }

    public function testPostToggleTask()
    {
        $httpClient = static::createClient();

        $crawler = $httpClient->request('POST', '/tasks/1/toggle');

        $this->assertEquals(Response::HTTP_FOUND, $httpClient->getResponse()->getStatusCode());

        $blackfireClient = $this->createBlackfireClient();
        $httpClient = static::createClient([], [
            'PHP_AUTH_USER' => 'Meli',
            'PHP_AUTH_PW' => 'azerty',
        ]);

        $profileConfiguration = (new ProfileConfiguration())->setTitle('post_toggle_task');
        $probe = $blackfireClient->createProbe($profileConfiguration);

        $crawler = $httpClient->request('POST', '/tasks/1/toggle');

        $profile = $blackfireClient->endProbe($probe);

        $this->assertEquals(Response::HTTP_FOUND, $httpClient->getResponse()->getStatusCode());

        $crawler = $httpClient->followRedirect();

        $this->assertEquals(Response::HTTP_OK, $httpClient->getResponse()->getStatusCode());
        $this->assertEquals('Superbe ! La tâche Lorem Ipsum a bien été marquée comme faite.', \trim($crawler->filter('.alert-success')->text()));
        $this->assertEquals('Lorem Ipsum', \trim($crawler->filter('.task')->eq(0)->filter('h4')->text()));
        $this->assertEquals('Lorem ipsum dolor sit amet consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', \trim($crawler->filter('.task')->eq(0)->filter('p')->text()));
        $this->assertEquals('glyphicon glyphicon-ok', \trim($crawler->filter('.task')->eq(0)->filter('.status span')->attr('class')));
        //$this->assertEquals('Meli', \trim($crawler->filter('.task')->eq(0)->filter('.author')->text()));

        $this->outputCost($profile, $profileConfiguration);
    }

    public function testPostDeleteTask()
    {
        $httpClient = static::createClient();

        $crawler = $httpClient->request('POST', '/tasks/1/delete');

        $this->assertEquals(Response::HTTP_FOUND, $httpClient->getResponse()->getStatusCode());

        $blackfireClient = $this->createBlackfireClient();
        $httpClient = static::createClient([], [
            'PHP_AUTH_USER' => 'Meli',
            'PHP_AUTH_PW' => 'azerty',
        ]);

        $profileConfiguration = (new ProfileConfiguration())->setTitle('post_toggle_task');
        $probe = $blackfireClient->createProbe($profileConfiguration);

        $crawler = $httpClient->request('POST', '/tasks/1/delete');

        $profile = $blackfireClient->endProbe($probe);

        $this->assertEquals(Response::HTTP_FOUND, $httpClient->getResponse()->getStatusCode());

        $crawler = $httpClient->followRedirect();

        $this->assertEquals(Response::HTTP_OK, $httpClient->getResponse()->getStatusCode());
        $this->assertEquals('Superbe ! La tâche a bien été supprimée.', \trim($crawler->filter('.alert-success')->text()));
        $this->assertEquals(1, $crawler->filter('.task')->count());

        $this->outputCost($profile, $profileConfiguration);
    }
}
