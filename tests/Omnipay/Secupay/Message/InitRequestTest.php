<?php

namespace Omnipay\Secupay\Message;

use Omnipay\Secupay\Message\InitRequest;
use Omnipay\Tests\TestCase;

class InitRequestTest extends TestCase
{
    private $request;

    public function setUp()
    {
        $client = $this->getHttpClient();
        $request = $this->getHttpRequest();

        $this->request = new InitRequest($client, $request);

        $this->options = array(
            'apiKey' => 'someApiKey',
            'paymentType' => 'debit',
            'amount' => (float)100,
            'currency' => 'EUR',
            'urlSuccess' => 'http://www.test.com/success',
            'urlFailure' => 'http://www.test.com/failure',
            'urlPush' => 'http://www.test.com/push',
        );

        $this->request->initialize($this->options);
    }

    public function testGetData()
    {
        $data = $this->request->getData();

        $this->assertSame($this->options['apiKey'], $data['data']['apikey']);
        $this->assertSame($this->options['paymentType'], $data['data']['payment_type']);
        $this->assertSame($this->options['amount'], (float)$data['data']['amount']);
        $this->assertSame($this->options['urlSuccess'], $data['data']['url_success']);
        $this->assertSame($this->options['urlFailure'], $data['data']['url_failure']);
        $this->assertSame($this->options['urlPush'], $data['data']['url_push']);
        $this->assertSame($this->options['currency'], $data['data']['currency']);
    }

    public function testSend()
    {
        $this->setMockHttpResponse('InitSuccess.txt');

        $response = $this->request->send();

        $this->assertTrue($response->isSuccessful());
        $this->assertEquals('spnzpmtwoeby20160', $response->getTransactionReference());
        $this->assertNull($response->getMessage());
    }
}
