<?php

namespace Tests\AppBundle\EventListener;

use AppBundle\Entity\Task;
use AppBundle\Entity\User;
use AppBundle\EventListener\AuthorizerListener;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormConfigBuilder;
use Symfony\Component\Form\FormEvent;

class AuthorizerListenerTest extends TestCase
{
    private $authorizerListener;
    private $user;
    private $task;

    protected function setUp()
    {
        $this->authorizerListener = new AuthorizerListener();

        $this->user = new User();
        $this->user->setUsername('Meli Melo');
        $this->user->setPassword('azerty');
        $this->user->setEmail('melimelo@example.com');
        $this->user->setRole(User::ROLE_USER);

        $this->task = new Task();
        $this->task->setTitle('Test');
        $this->task->setContent('Content.');
    }

    public function provideUnauthorizationRequestMethods()
    {
        $methods = [
            ['GET'],
            ['PATCH'],
            ['PUT'],
            ['DELETE'],
        ];

        foreach ($methods as $method) {
            yield $method;
        }
    }

    public function testTaskAuthorization()
    {
        $this->authorizerListener->onFormSubmit($this->getFormEventMock('POST'), $this->user);

        $this->assertEquals($this->task->getAuthor(), $this->user);
    }

    /**
     * @dataProvider provideUnauthorizationRequestMethods
     */
    public function testTaskUnauthorization($requestMethod)
    {
        $this->authorizerListener->onFormSubmit($this->getFormEventMock($requestMethod), $this->user);

        $this->assertNull($this->task->getAuthor());
    }

    public function testTaskAuthorizationWithNullUser()
    {
        $this->user = null;

        $this->authorizerListener->onFormSubmit($this->getFormEventMock('POST'), $this->user);

        $this->assertNull($this->task->getAuthor());
    }

    public function testNonAuthorizableAuthorization()
    {
        $this->task = null;
        
        $this->authorizerListener->onFormSubmit($this->getFormEventMock('POST'), $this->user);

        $this->assertNull($this->task);
    }

    private function getFormEventMock(string $requestMethod)
    {
        $formConfig = $this->getMockBuilder(FormConfigBuilder::class)
            ->disableOriginalConstructor()
            ->setMethods(['getMethod'])
            ->getMock()
        ;
        $formConfig
            ->method('getMethod')
            ->willReturn($requestMethod)
        ;

        $form = $this->getMockBuilder(Form::class)
            ->disableOriginalConstructor()
            ->setMethods(['getConfig'])
            ->getMock()
        ;
        $form
            ->method('getConfig')
            ->willReturn($formConfig)
        ;

        $event = $this->getMockBuilder(FormEvent::class)
            ->disableOriginalConstructor()
            ->setMethods(['getData', 'getForm'])
            ->getMock()
        ;
        $event
            ->method('getData')
            ->willReturn($this->task)
        ;
        $event
            ->method('getForm')
            ->willReturn($form)
        ;

        return $event;
    }
}
