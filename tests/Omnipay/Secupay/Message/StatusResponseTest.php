<?php

namespace Omnipay\Secupay\Message;

use Omnipay\Tests\TestCase;

class StatusResponseTest extends TestCase
{
    public function testStatusSuccess()
    {
        $httpResponse = $this->getMockHttpResponse('StatusSuccess.txt');
        $response = new Response($this->getMockRequest(), $httpResponse->json());

        /* Check the request details */
        $this->assertTrue($response->isSuccessful());
        $this->assertFalse($response->isRedirect());
        $this->assertSame('ok', $response->getStatus());

        /* Check the errors */
        $this->assertNull($response->getMessage());
        $this->assertNull($response->getErrorCode());
        $this->assertNull($response->getErrors());

        /* Check the transaction details */
        $this->assertSame('xthlpleknqvt20214', $response->getTransactionReference());
        $this->assertSame('2449700', $response->getTransactionId());
        $this->assertSame('accepted', $response->getTransactionStatus());

        /* Check the additional data */
        $this->assertNotNull($response->getData());
        $this->assertNull($response->getIframeUrl());
        $this->assertNotNull($response->getRaw());
    }

    public function testStatusFailure()
    {
        $httpResponse = $this->getMockHttpResponse('StatusFailure.txt');
        $response = new Response($this->getMockRequest(), $httpResponse->json());

        /* Check the request details */
        $this->assertFalse($response->isSuccessful());
        $this->assertFalse($response->isRedirect());
        $this->assertSame('failed', $response->getStatus());

        /* Check the errors */
        $this->assertSame('Ungültiger hash', $response->getMessage());
        $this->assertSame('0002', $response->getErrorCode());
        $this->assertNotNull($response->getErrors());

        /* Check the transaction details */
        $this->assertSame('stuff', $response->getTransactionReference());
        $this->assertNull($response->getTransactionId());
        $this->assertNull($response->getTransactionStatus());

        /* Check the additional data */
        $this->assertNotNull($response->getData());
        $this->assertNull($response->getIframeUrl());
        $this->assertNotNull($response->getRaw());
    }
}
