<?php

namespace Tests\AppBundle\Entity;

use AppBundle\Entity\Task;
use PHPUnit\Framework\TestCase;

class TaskTest extends TestCase
{
    public function testConstruct()
    {
        $task = new Task();
        $now = new \DateTime();

        $this->assertInstanceOf(\DateTime::class, $task->getCreatedAt());

        $dateInterval = $now->diff($task->getCreatedAt());
        
        $this->assertEquals('00000', \sprintf('%d%d%d%d%d', $dateInterval->y, $dateInterval->m, $dateInterval->d, $dateInterval->h, $dateInterval->i));
        $this->assertEquals(false, $task->isDone());
    }

    public function testSetCreatedAt()
    {
        $task = new Task();
        $dateTime = new \DateTime('2011-01-01T15:03:01');

        $task->setCreatedAt($dateTime);

        $this->assertInstanceOf(\DateTime::class, $task->getCreatedAt());

        $this->assertEquals($dateTime->getTimestamp(), $task->getCreatedAt()->getTimestamp());
    }

    public function testToggle()
    {
        $task = new Task();

        $task->toggle(true);
        
        $this->assertEquals(true, $task->isDone());

        $task->toggle(false);
        
        $this->assertEquals(false, $task->isDone());
    }
}
