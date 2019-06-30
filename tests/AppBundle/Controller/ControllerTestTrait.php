<?php

namespace Tests\AppBundle\Controller;

use AppBundle\Framework\CostAwareTestClient;

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
     * @return CostAwareTestClient
     */
    private function createUnauthenticatedTestClient(): CostAwareTestClient
    {
        return static::createClient();
    }

    /**
     * Creates an authenticated test client.
     *
     * @return CostAwareTestClient
     */
    private function createAuthenticatedTestClient(): CostAwareTestClient
    {
        return static::createClient([], [
            'PHP_AUTH_USER' => 'Meli',
            'PHP_AUTH_PW' => 'azerty',
        ]);
    }
}
