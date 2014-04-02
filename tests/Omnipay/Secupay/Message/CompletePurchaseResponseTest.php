<?php

namespace Omnipay\Secupay\Message;

use Omnipay\Tests\TestCase;

class CompletePurchaseResponseTest extends TestCase
{
    public function testCompletePurchaseSuccess()
    {
        $httpResponse = $this->getMockHttpResponse('CompletePurchaseSuccess.txt');
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
        $this->assertSame('2449693', $response->getTransactionId());
        $this->assertNull($response->getTransactionStatus());

        /* Check the additional data */
        $this->assertNotNull($response->getData());
        $this->assertNull($response->getIframeUrl());
        $this->assertNotNull($response->getRaw());
    }

    public function testCompletePurchaseFailure()
    {
        $httpResponse = $this->getMockHttpResponse('CompletePurchaseFailure.txt');
        $response = new Response($this->getMockRequest(), $httpResponse->json());

        /* Check the request details */
        $this->assertFalse($response->isSuccessful());
        $this->assertFalse($response->isRedirect());
        $this->assertSame('failed', $response->getStatus());

        /* Check the errors */
        $this->assertContains('Apikey stimmt nicht überein', $response->getMessage());
        $this->assertSame('0013', $response->getErrorCode());
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
