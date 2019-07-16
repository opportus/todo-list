<?php

namespace AppBundle\Framework;

use Blackfire\Client as BlackfireClient;
use Blackfire\ClientConfiguration as BlackfireClientConfiguration;
use Blackfire\Profile;
use Blackfire\Profile\Configuration as ProfileConfiguration;
use Blackfire\Profile\Cost;
use Symfony\Bundle\FrameworkBundle\Client as TestClient;
use Symfony\Component\BrowserKit\Exception\BadMethodCallException;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\DomCrawler\Form;

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
     * @var ProfileConfiguration $profileConfiguration
     */
    private $profileConfiguration;

    /**
     * Gets the current cost.
     *
     * @return Cost
     * @throws Exception
     */
    public function getCost(): Cost
    {
        if (null === $this->profile) {
            throw new BadMethodCallException(\sprintf('The "requestAndProfile()" or "submitAndProfile()" method must be called before "%s()".', __METHOD__));
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
     * Requests and profiles.
     *
     * @param string $method
     * @param string $uri
     * @param array $parameters
     * @param array $files
     * @param array $server
     * @param null|string $content
     * @param boolean $changeHistory
     * @return Crawler
     */
    public function requestAndProfile($method, $uri, array $parameters = array(), array $files = array(), array $server = array(), $content = null, $changeHistory = true)
    {
        $blackfireClient = new BlackfireClient(new BlackfireClientConfiguration(\getenv('BLACKFIRE_CLIENT_ID'), \getenv('BLACKFIRE_CLIENT_TOKEN')));
        $this->profileConfiguration = new ProfileConfiguration();
        $this->profileConfiguration->setTitle(\sprintf('%s %s', $method, $uri));

        $probe = $blackfireClient->createProbe($this->profileConfiguration);

        $crawler = parent::request($method, $uri, $parameters, $files, $server, $content, $changeHistory);

        $this->profile = $blackfireClient->endProbe($probe);

        return $crawler;
    }

    /**
     * Submits and profiles.
     *
     * @param Form $form
     * @param array $values
     * @param array $serverParameters
     * @return Crawler
     */
    public function submitAndProfile(Form $form, array $values = [], array $serverParameters = [])
    {
        $blackfireClient = new BlackfireClient(new BlackfireClientConfiguration(\getenv('BLACKFIRE_CLIENT_ID'), \getenv('BLACKFIRE_CLIENT_TOKEN')));
        $this->profileConfiguration = new ProfileConfiguration();
        $this->profileConfiguration->setTitle(\sprintf('%s %s', $form->getMethod(), $form->getUri()));

        $probe = $blackfireClient->createProbe($this->profileConfiguration);

        $crawler = parent::submit($form, $values, $serverParameters);

        $this->profile = $blackfireClient->endProbe($probe);

        return $crawler;
    }
}
