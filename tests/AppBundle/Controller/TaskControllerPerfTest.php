<?php

namespace Tests\AppBundle\Controller;

use AppBundle\Framework\Test\CostAwareWebTestCase;

class TaskControllerPerfTest extends CostAwareWebTestCase
{
    use ControllerTestTrait;

    public function testGetTaskListWithAdminRole()
    {
        $testClient = $this->createTestClientWithAdminRole();

        $testClient->requestAndProfile('GET', '/tasks');
    }

    public function testGetCreateTaskWithAdminRole()
    {
        $testClient = $this->createTestClientWithAdminRole();

        $testClient->requestAndProfile('GET', '/tasks/create');
    }

    public function testPostCreateTaskWithAdminRole()
    {
        $testClient = $this->createTestClientWithAdminRole();

        $crawler = $testClient->request('GET', '/tasks/create');

        $form = $crawler->selectButton('Ajouter')->form([
            'task[title]' => 'Test Task',
            'task[content]' => 'This is a test task.',
        ]);

        $testClient->submitAndProfile($form);
    }

    public function testGetEditTaskWithAdminRole()
    {
        $testClient = $this->createTestClientWithAdminRole();

        $testClient->requestAndProfile('GET', '/tasks/1/edit');
    }

    public function testPostEditTaskWithAdminRole()
    {
        $testClient = $this->createTestClientWithAdminRole();

        $crawler = $testClient->request('GET', '/tasks/1/edit');

        $form = $crawler->selectButton('Modifier')->form([
            'task[title]' => 'Updated Test Task',
            'task[content]' => 'This is an updated test task.',
        ]);

        $testClient->submitAndProfile($form);
    }

    public function testPostToggleTaskWithAdminRole()
    {
        $testClient = $this->createTestClientWithAdminRole();

        $testClient->requestAndProfile('POST', '/tasks/1/toggle');
    }

    public function testPostDeleteTaskWithAdminRole()
    {
        $testClient = $this->createTestClientWithAdminRole();

        $testClient->requestAndProfile('POST', '/tasks/1/delete');
    }
}
