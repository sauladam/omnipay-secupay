<?php

namespace Omnipay\Secupay\Message;

use Omnipay\Tests\TestCase;

class VoidRequestTest extends TestCase
{
    private $request;

    private $options;

    public function setUp()
    {
        $client = $this->getHttpClient();
        $request = $this->getHttpRequest();
        
        $this->request = new VoidRequest($client, $request);

        $this->options = array(
            'apiKey' => 'someApiKey',
            'hash' => 'someHash'
        );

        $this->request->initialize($this->options);
    }

    public function testGetData()
    {
        $data = $this->request->getData();

        $this->assertSame($this->options['apiKey'], $data['data']['apikey']);
        $this->assertSame($this->options['hash'], $data['data']['hash']);
    }

    public function testSend()
    {
        $this->setMockHttpResponse('VoidSuccess.txt');

        $response = $this->request->send();

        $this->assertTrue($response->isSuccessful());
        $this->assertNull($response->getTransactionReference());
        $this->assertSame('2449737', $response->getTransactionId());
        $this->assertNull($response->getMessage());
    }
}
