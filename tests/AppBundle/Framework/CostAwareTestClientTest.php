<?php

namespace Tests\AppBundle\Framework;

use AppBundle\Framework\Test\CostAwareWebTestCase;

class CostAwareTestClientTest extends CostAwareWebTestCase
{
    public function testGetCostException()
    {
        $client = self::createClient();

        $this->expectException(\BadMethodCallException::class);

        $client->getCost();
    }

    public function testOutputCostException()
    {
        $client = self::createClient();

        $this->expectException(\BadMethodCallException::class);

        $client->outputCost();
    }
}
