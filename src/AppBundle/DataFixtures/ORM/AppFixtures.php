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
        foreach ($this->generateData() as $entitiesType => $entitiesData) {
            foreach ($entitiesData as $entityData) {
                $entity = new $entitiesType();

                foreach ($entityData as $setter => $arguments) {
                    $entity->{$setter}(...(array)$arguments);
                }

                $entityManager->persist($entity);
            }
        }

        $entityManager->flush();
    }

    private function generateData()
    {
        $password = $this->container->get('security.password_encoder')->encodePassword(new User(), 'azerty');

        return [
            User::class => [
                ['setUsername' => 'Meli', 'setEmail' => 'meli@example.com', 'setPassword' => $password],
                ['setUsername' => 'Melo', 'setEmail' => 'melo@example.com', 'setPassword' => $password],
            ],
            Task::class => [
                ['setTitle' => 'Lorem Ipsum', 'setContent' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.'],
                ['setTitle' => 'Lorem Ipsum', 'setContent' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.']
            ],
        ];
    }
}
