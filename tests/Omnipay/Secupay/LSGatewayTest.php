<?php

namespace Omnipay\Secupay;

class LSGatewayTest extends AbstractGatewayTest
{

    /**
     * Set up the testing environment.
     */
    public function setUp()
    {
        $this->gateway = new LSGateway($this->getHttpClient(), $this->getHttpRequest());
    }
}
