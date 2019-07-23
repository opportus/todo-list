<?php

namespace Tests\AppBundle\Controller;

use AppBundle\Framework\Test\CostAwareWebTestCase;

class DefaultControllerPerfTest extends CostAwareWebTestCase
{
    use ControllerTestTrait;

    public function testGetHomepageWithUserRole()
    {
        $testClient = $this->createTestClientWithUserRole();

        $testClient->requestAndProfile('GET', '/');
    }
}
