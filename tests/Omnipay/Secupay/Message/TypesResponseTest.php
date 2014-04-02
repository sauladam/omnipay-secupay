<?php

namespace Omnipay\Secupay\Message;

use Omnipay\Tests\TestCase;

class TypesResponseTest extends TestCase
{
    public function testTypesSuccess()
    {
        $httpResponse = $this->getMockHttpResponse('TypesSuccess.txt');
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
        $this->assertNull($response->getTransactionId());
        $this->assertNull($response->getTransactionStatus());

        /* Check the additional data */
        $this->assertContains('debit', $response->getData());
        $this->assertContains('creditcard', $response->getData());
        $this->assertNull($response->getIframeUrl());
        $this->assertNotNull($response->getRaw());
    }

    public function testTypesFailure()
    {
        $httpResponse = $this->getMockHttpResponse('TypesFailure.txt');
        $response = new Response($this->getMockRequest(), $httpResponse->json());

        /* Check the request details */
        $this->assertFalse($response->isSuccessful());
        $this->assertFalse($response->isRedirect());
        $this->assertSame('error', $response->getStatus());

        /* Check the errors */
        $this->assertSame('Ungültiger apikey', $response->getMessage());
        $this->assertSame('0001', $response->getErrorCode());
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
