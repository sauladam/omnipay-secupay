<?php

namespace Omnipay\Secupay\Message;

use Omnipay\Tests\TestCase;

class TypesRequestTest extends TestCase
{
    private $request;

    private $options;

    public function setUp()
    {
        $client = $this->getHttpClient();
        $request = $this->getHttpRequest();
        
        $this->request = new TypesRequest($client, $request);

        $this->options = array(
            'apiKey' => 'someApiKey',
        );

        $this->request->initialize($this->options);
    }

    public function testGetData()
    {
        $data = $this->request->getData();

        $this->assertSame($this->options['apiKey'], $data['data']['apikey']);
    }

    public function testSend()
    {
        $this->setMockHttpResponse('TypesSuccess.txt');

        $response = $this->request->send();

        $this->assertTrue($response->isSuccessful());
        $this->assertNotNull($response->getData());
        $this->assertInternalType('array', $response->getData());
    }
}
