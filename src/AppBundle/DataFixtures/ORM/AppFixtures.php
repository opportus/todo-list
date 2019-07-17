<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Task;
use AppBundle\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;

class AppFixtures extends Fixture implements ContainerAwareInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $entityManager)
    {
        $users = [];
        foreach ($this->generateUserData() as $userData) {
            $users[] = $user = new User();

            foreach ($userData as $setter => $arguments) {
                $user->{$setter}(...(array)$arguments);
            }

            $entityManager->persist($user);
        }

        $entityManager->flush();

        foreach ($this->generateTaskData($users) as $taskData) {
            $task = new Task();

            foreach ($taskData as $setter => $argument) {
                $task->{$setter}($argument);
            }

            $entityManager->persist($task);
        }

        $entityManager->flush();
    }

    private function generateUserData()
    {
        $password = $this->container->get('security.password_encoder')->encodePassword(new User(), 'azerty');

        return [
            ['setUsername' => 'Meli', 'setEmail' => 'meli@example.com', 'setPassword' => $password, 'setRoles' => User::ROLE_ADMIN],
            ['setUsername' => 'Melo', 'setEmail' => 'melo@example.com', 'setPassword' => $password, 'setRoles' => User::ROLE_USER],
        ];
    }

    private function generateTaskData($users)
    {
        return [
            ['setTitle' => 'Lorem Ipsum', 'setContent' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'setAuthor' => $users[0]],
            ['setTitle' => 'Lorem Ipsum', 'setContent' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'setAuthor' => $users[1]]
        ];
    }
}
