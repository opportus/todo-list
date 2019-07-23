<?php

namespace Tests\AppBundle\Form\Type;

use AppBundle\Entity\Task;
use AppBundle\Entity\User;
use AppBundle\Form\Type\TaskType;
use Symfony\Component\Form\Test\TypeTestCase;

class TaskTypeTest extends TypeTestCase
{
    public function testSubmitValidData()
    {
        $user = new User();
        $user->setUsername('Meli Melo');
        $user->setPassword('azerty');
        $user->setEmail('melimelo@example.com');
        $user->setRole(User::ROLE_USER);

        $datetime = new \DateTime();

        $taskToCompare = new Task();
        $taskToCompare->setCreatedAt($datetime);

        $form = $this->factory->create(TaskType::class, $taskToCompare, ['user' => $user]);

        $task = new Task();
        $task->setTitle('Test');
        $task->setContent('Content.');
        $task->setAuthor($user);
        $task->setCreatedAt($datetime);

        $formData = [
            'title'   => 'Test',
            'content' => 'Content.'
        ];

        $form->submit($formData);

        $this->assertTrue($form->isSynchronized());
        $this->assertEquals($task, $taskToCompare);

        $view = $form->createView();
        $children = $view->children;

        foreach (\array_keys($formData) as $key) {
            $this->assertArrayHasKey($key, $children);
        }
    }
}
