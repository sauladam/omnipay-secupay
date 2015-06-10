<?php

namespace Omnipay\Secupay\Message;

use Omnipay\Tests\TestCase;

class VoidRequestTest extends TestCase
{

    /**
     * @var VoidRequest
     */
    protected $request;

    /**
     * @var array
     */
    protected $options;


    /**
     * Set up the testing environment.
     */
    public function setUp()
    {
        $request = new VoidRequest($this->getHttpClient(), $this->getHttpRequest());

        $options = [
            'apiKey' => 'someApiKey',
            'hash'   => 'someHash'
        ];

        $this->request = $request->initialize($options);
        $this->options = $options;
    }


    /** @test */
    public function it_gets_the_correct_data_from_the_request()
    {
        $data = $this->request->getData()['data'];

        $this->assertSame($this->options['apiKey'], $data['apikey']);
        $this->assertSame($this->options['hash'], $data['hash']);
    }


    /** @test */
    public function it_returns_the_expected_response_type()
    {
        $this->setMockHttpResponse('VoidSuccess.txt');

        $response = $this->request->send();

        $this->assertInstanceOf('Omnipay\Secupay\Message\Response', $response);
    }
}
