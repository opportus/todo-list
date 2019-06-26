<?php

namespace Tests\AppBundle\Controller;

use Blackfire\Client as BlackfireClient;
use Blackfire\ClientConfiguration as BlackfireClientConfiguration;
use Blackfire\Profile as Profile;
use Blackfire\Profile\Configuration as ProfileConfiguration;

trait ControllerTestTrait
{
    private function createBlackfireClient(): BlackfireClient
    {
        return new BlackfireClient(BlackfireClientConfiguration::createFromFile((self::createKernel())->getRootDir().'\..\.blackfire.ini'));
    }

    private function outputCost(Profile $blackfireProfile, ProfileConfiguration $profileConfiguration)
    {
        $cost = $blackfireProfile->getMainCost();

        \fwrite(\STDERR, \sprintf('"%s" profile:', $profileConfiguration->getTitle()));
        \fwrite(\STDERR, \sprintf('%s', \PHP_EOL.\PHP_EOL));
        \fwrite(\STDERR, \sprintf('Wall Time:    %d ms', \round($cost->getWallTime()/1000)));
        \fwrite(\STDERR, \sprintf('%s', \PHP_EOL));
        \fwrite(\STDERR, \sprintf('Memory Usage: %d MB', \round($cost->getMemoryUsage()/1000000)));
        \fwrite(\STDERR, \sprintf('%s', \PHP_EOL.\PHP_EOL));
    }
}
