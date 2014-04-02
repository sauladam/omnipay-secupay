<?php

namespace Omnipay\Secupay\Message;

use Omnipay\Tests\TestCase;

class CompletePurchaseRequestTest extends TestCase
{
    private $request;

    public function setUp()
    {
        $client = $this->getHttpClient();
        $request = $this->getHttpRequest();

        $this->request = new CompletePurchaseRequest($client, $request);

        $this->options = array(
            'apiKey' => 'someApiKey',
            'iframeUrl' => 'https://api-dist.secupay-ag.de/payment/ejwyhqidngzu20208',
        );

        $this->request->initialize($this->options);
    }

    public function testGetData()
    {
        $data = $this->request->getData();

        $this->assertSame($this->options['apiKey'], $data['data']['apikey']);
        $this->assertSame($this->options['iframeUrl'], $this->request->getIframeUrl());
    }

    public function testSend()
    {
        $this->setMockHttpResponse('CompletePurchaseSuccess.txt');

        $response = $this->request->send();

        $this->assertTrue($response->isSuccessful());
        $this->assertFalse($response->isRedirect());
        $this->assertNull($response->getMessage());
    }
}
