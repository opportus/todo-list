<?php

namespace AppBundle\Framework\Test;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * The cost aware web test case.
 *
 * @package AppBundle\Test
 * @author Clément Cazaud <opportus@gmail.com>
 */
class CostAwareWebTestCase extends WebTestCase
{
    /**
     * {@inheritdoc}
     */
    protected static function createClient(array $options = [], array $server = [])
    {
        static::bootKernel($options);

        $client = static::$kernel->getContainer()->get('AppBundle\Framework\CostAwareTestClient');

        $client->setServerParameters($server);

        return $client;
    }
}
