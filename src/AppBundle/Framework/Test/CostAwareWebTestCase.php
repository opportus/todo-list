<?php

namespace AppBundle\Framework\Test;

use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException;

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

        $client = static::$kernel->getContainer()->get('app.cost_aware_test_client');

        $client->setServerParameters($server);

        return $client;
    }
}
