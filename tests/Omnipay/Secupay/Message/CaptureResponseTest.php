<?php

namespace Omnipay\Secupay\Message;

use Omnipay\Tests\TestCase;

class CaptureResponseTest extends TestCase
{
    public function testInitSuccess()
    {
        $httpResponse = $this->getMockHttpResponse('CaptureSuccess.txt');
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
        $this->assertSame('vcikqjglpdti20245', $response->getTransactionReference());
        $this->assertSame('2449731', $response->getTransactionId());
        $this->assertSame('ok', $response->getTransactionStatus());
        
        /* Check the additional data */
        $this->assertNotNull($response->getData());
        $this->assertNull($response->getIframeUrl());
        $this->assertNotNull($response->getRaw());
    }

    public function testInitFailure()
    {
        $httpResponse = $this->getMockHttpResponse('CaptureFailure.txt');
        $response = new Response($this->getMockRequest(), $httpResponse->json());

        /* Check the request details */
        $this->assertFalse($response->isSuccessful());
        $this->assertFalse($response->isRedirect());
        $this->assertSame('failed', $response->getStatus());

        /* Check the errors */
        $this->assertSame('Zahlung konnte nicht abgeschlossen werden', $response->getMessage());
        $this->assertSame('0014', $response->getErrorCode());
        $this->assertNotNull($response->getErrors());

        /* Check the transaction details */
        $this->assertSame('bzymhauuszgf20241', $response->getTransactionReference());
        $this->assertNull($response->getTransactionId());
        $this->assertNull($response->getTransactionStatus());

        /* Check the additional data */
        $this->assertNotNull($response->getData());
        $this->assertNull($response->getIframeUrl());
        $this->assertNotNull($response->getRaw());
    }
}
