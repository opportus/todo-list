<?php

namespace Tests\AppBundle\Controller;

use AppBundle\Framework\Test\CostAwareWebTestCase;

class DefaultControllerPerfTest extends CostAwareWebTestCase
{
    use ControllerTestTrait;

    public function testGetHomepageAuthenticated()
    {
        $testClient = $this->createAuthenticatedTestClient();

        $testClient->requestAndProfile('GET', '/');

        $testClient->outputCost();
    }
}
