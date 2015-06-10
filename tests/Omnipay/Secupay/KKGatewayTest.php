<?php

namespace Omnipay\Secupay;

class KKGatewayTest extends AbstractGatewayTest
{

    /**
     * Set up the testing environment.
     */
    public function setUp()
    {
        $this->gateway = new KKGateway($this->getHttpClient(), $this->getHttpRequest());
    }
}
