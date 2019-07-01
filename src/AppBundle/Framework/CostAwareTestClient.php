<?php

namespace AppBundle\Framework;

use Blackfire\Client as BlackfireClient;
use Blackfire\ClientConfiguration as BlackfireClientConfiguration;
use Blackfire\Profile;
use Blackfire\Profile\Configuration as ProfileConfiguration;
use Blackfire\Profile\Cost;
use Symfony\Bundle\FrameworkBundle\Client as TestClient;
use Symfony\Component\BrowserKit\Exception\BadMethodCallException;

/**
 * The cost aware test client.
 *
 * @package AppBundle\Framework
 * @author Clément Cazaud <opportus@gmail.com>
 */
final class CostAwareTestClient extends TestClient
{
    /**
     * @var Profile $profile
     */
    private $profile;

    /**
     * Gets the current cost.
     *
     * @return Cost
     * @throws Exception
     */
    public function getCost(): Cost
    {
        if (null === $this->profile) {
            throw new BadMethodCallException(\sprintf('The "request()" method must be called before "%s()".', __METHOD__));
        }

        return $this->profile->getMainCost();
    }

    /**
     * Outputs the current cost.
     */
    public function outputCost()
    {
        $cost = $this->getCost();

        \fwrite(\STDERR, \sprintf('"%s" profile:', $this->profileConfiguration->getTitle()));
        \fwrite(\STDERR, \sprintf('%s', \PHP_EOL.\PHP_EOL));
        \fwrite(\STDERR, \sprintf('Wall Time:    %d ms', \round($cost->getWallTime()/1000)));
        \fwrite(\STDERR, \sprintf('%s', \PHP_EOL));
        \fwrite(\STDERR, \sprintf('Memory Usage: %d MB', \round($cost->getMemoryUsage()/1000000)));
        \fwrite(\STDERR, \sprintf('%s', \PHP_EOL.\PHP_EOL));
    }

    /**
     * {@inheritdoc}
     */
    public function request($method, $uri, array $parameters = array(), array $files = array(), array $server = array(), $content = null, $changeHistory = true)
    {
        $blackfireClient = new BlackfireClient(BlackfireClientConfiguration::createFromFile($this->getBlackfireClientConfigurationFilePath()));

        $probe = $blackfireClient->createProbe((new ProfileConfiguration())->setTitle(\sprintf('%s %s', $method, $uri)));

        $crawler = parent::request($method, $uri, $parameters, $files, $server, $content, $changeHistory);

        $this->profile = $blackfireClient->endProbe($probe);

        return $crawler;
    }

    /**
     * Gets the Blackfire client configuration file path.
     *
     * @return string
     */
    private function getBlackfireClientConfigurationFilePath(): string
    {
        $rootDir = $this->getKernel()->getRootDir();
        $rootDir = \substr($rootDir, 0, \strrpos($rootDir, \DIRECTORY_SEPARATOR.'app')+1);

        $path = $rootDir.'.blackfire.ini';

        if (!\file_exists($path)) {
            throw new \Exception(\sprintf('Blackfire client configuration file "%s" does not exist.', $path));
        }

        return $path;
    }
}
