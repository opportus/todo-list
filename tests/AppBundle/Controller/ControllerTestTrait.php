<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Client as TestClient;

/**
 * The controller test trait.
 *
 * @package Tests\AppBundle\Controller
 * @author Clément Cazaud <opportus@gmail.com>
 */
trait ControllerTestTrait
{
    /**
     * Creates an unauthenticated test client.
     *
     * @return TestClient
     */
    private function createUnauthenticatedTestClient(): TestClient
    {
        return static::createClient();
    }

    /**
     * Creates an authenticated test client.
     *
     * @return TestClient
     */
    private function createAuthenticatedTestClient(): TestClient
    {
        return static::createClient([], [
            'PHP_AUTH_USER' => 'Meli',
            'PHP_AUTH_PW' => 'azerty',
        ]);
    }
}
