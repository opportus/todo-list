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
        /*$kernel = static::bootKernel($options);

        try {
            $client = $kernel->getContainer()->get('app.cost_aware_test_client');
        } catch (ServiceNotFoundException $e) {
            if (\class_exists(KernelBrowser::class)) {
                throw new \LogicException('You cannot create the client used in functional tests if the "framework.test" config is not set to true.');
            }

            throw new \LogicException('You cannot create the client used in functional tests if the BrowserKit component is not available. Try running "composer require symfony/browser-kit"');
        }

        $client->setServerParameters($server);

        return self::getClient($client);*/
        static::bootKernel($options);



        $client = static::$kernel->getContainer()->get('app.cost_aware_test_client');

        $client->setServerParameters($server);



        return $client;
    }
}
