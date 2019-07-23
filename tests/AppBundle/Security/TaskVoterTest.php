<?php

namespace Tests\AppBundle\Security;

use AppBundle\Entity\Task;
use AppBundle\Entity\User;
use AppBundle\Security\TaskVoter;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\VoterInterface;

class TaskVoterTest extends TestCase
{
    private static $task;
    private $token;

    public static function setUpBeforeClass(): void
    {
        $taskAuthor = new User();
        $taskAuthor->setUsername('Meli');

        self::$task = new Task();
        self::$task->setAuthor($taskAuthor);
    }

    public function setUp(): void
    {
        $user = new User();
        $user->setUsername($this->getProvidedData()[1]);

        $this->token = $this->getMockBuilder(TokenInterface::class)->getMock();
        $this->token->method('getUser')->willReturn($user);

    }

    public function getTests()
    {
        return [
            [['DELETE'], 'Meli', VoterInterface::ACCESS_GRANTED],
            [['DELETE'], 'Melo', VoterInterface::ACCESS_DENIED],
            [[], 'Meli', VoterInterface::ACCESS_ABSTAIN]
        ];
    }

    /**
     * @dataProvider getTests
     */
    public function testVote($attributes, $username, $expectedVote)
    {
        $voter = new TaskVoter();

        $this->assertEquals($expectedVote, $voter->vote($this->token, self::$task, $attributes));
    }
}
