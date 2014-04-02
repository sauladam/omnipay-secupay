<?php

namespace Omnipay\Secupay\Message;

use Omnipay\Tests\TestCase;

class VoidResponseTest extends TestCase
{
    public function testVoidSuccess()
    {
        $httpResponse = $this->getMockHttpResponse('VoidSuccess.txt');
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
        $this->assertNull($response->getTransactionReference());
        $this->assertSame('2449737', $response->getTransactionId());
        $this->assertNull($response->getTransactionStatus());

        /* Check the additional data */
        $this->assertNotNull($response->getData());
        $this->assertNull($response->getIframeUrl());
        $this->assertNotNull($response->getRaw());
    }

    public function testVoidFailure()
    {
        $httpResponse = $this->getMockHttpResponse('VoidFailure.txt');
        $response = new Response($this->getMockRequest(), $httpResponse->json());

        /* Check the request details */
        $this->assertFalse($response->isSuccessful());
        $this->assertFalse($response->isRedirect());
        $this->assertSame('failed', $response->getStatus());

        /* Check the errors */
        $this->assertSame('Hash wurde schon verarbeitet', $response->getMessage());
        $this->assertSame('0008', $response->getErrorCode());
        $this->assertNotNull($response->getErrors());

        /* Check the transaction details */
        $this->assertNull($response->getTransactionReference());
        $this->assertNull($response->getTransactionId());
        $this->assertNull($response->getTransactionStatus());

        /* Check the additional data */
        $this->assertNull($response->getData());
        $this->assertNull($response->getIframeUrl());
        $this->assertNotNull($response->getRaw());
    }
}
