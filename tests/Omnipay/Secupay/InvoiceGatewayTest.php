<?php

namespace Omnipay\Secupay;

class InvoiceGatewayTest extends AbstractGatewayTest
{

    /**
     * Set up the testing environment.
     */
    public function setUp()
    {
        $this->gateway = new InvoiceGateway($this->getHttpClient(), $this->getHttpRequest());
    }
}
