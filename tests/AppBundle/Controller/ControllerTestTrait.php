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
     * Creates a test client.
     *
     * @return TestClient
     */
    private function createTestClientWithNoRole(): TestClient
    {
        return static::createClient();
    }

    /**
     * Creates a test client with admin role.
     *
     * @return TestClient
     */
    private function createTestClientWithAdminRole(): TestClient
    {
        return static::createClient([], [
            'PHP_AUTH_USER' => 'Meli',
            'PHP_AUTH_PW' => 'azerty',
        ]);
    }

    /**
     * Creates a test client with user role.
     *
     * @return TestClient
     */
    private function createTestClientWithUserRole(): TestClient
    {
        return static::createClient([], [
            'PHP_AUTH_USER' => 'Melo',
            'PHP_AUTH_PW' => 'azerty',
        ]);
    }
}
