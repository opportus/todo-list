<?php

namespace Tests\AppBundle\Controller;

use AppBundle\Framework\Test\CostAwareWebTestCase;

class TaskControllerPerfTest extends CostAwareWebTestCase
{
    use ControllerTestTrait;

    public function testGetTaskListAuthenticated()
    {
        $testClient = $this->createAuthenticatedTestClient();

        $testClient->requestAndProfile('GET', '/tasks');

        $testClient->outputCost();
    }

    public function testGetCreateTaskAuthenticated()
    {
        $testClient = $this->createAuthenticatedTestClient();

        $testClient->requestAndProfile('GET', '/tasks/create');

        $testClient->outputCost();
    }

    public function testPostCreateTaskAuthenticated()
    {
        $testClient = $this->createAuthenticatedTestClient();

        $crawler = $testClient->request('GET', '/tasks/create');

        $form = $crawler->selectButton('Ajouter')->form([
            'task[title]' => 'Test Task',
            'task[content]' => 'This is a test task.',
        ]);

        $testClient->submitAndProfile($form);

        $testClient->outputCost();
    }

    public function testGetEditTaskAuthenticated()
    {
        $testClient = $this->createAuthenticatedTestClient();

        $testClient->requestAndProfile('GET', '/tasks/1/edit');

        $testClient->outputCost();
    }

    public function testPostEditTaskAuthenticated()
    {
        $testClient = $this->createAuthenticatedTestClient();

        $crawler = $testClient->request('GET', '/tasks/1/edit');

        $form = $crawler->selectButton('Modifier')->form([
            'task[title]' => 'Updated Test Task',
            'task[content]' => 'This is an updated test task.',
        ]);

        $testClient->submitAndProfile($form);

        $testClient->outputCost();
    }

    public function testPostToggleTaskAuthenticated()
    {
        $testClient = $this->createAuthenticatedTestClient();

        $testClient->requestAndProfile('POST', '/tasks/1/toggle');

        $testClient->outputCost();
    }

    public function testPostDeleteTaskAuthenticated()
    {
        $testClient = $this->createAuthenticatedTestClient();

        $testClient->requestAndProfile('POST', '/tasks/1/delete');

        $testClient->outputCost();
    }
}
