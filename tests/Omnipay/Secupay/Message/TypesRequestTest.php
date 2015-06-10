<?php

namespace Omnipay\Secupay\Message;

use Omnipay\Tests\TestCase;

class TypesRequestTest extends TestCase
{

    /**
     * @var TypesRequest
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
        $request = new TypesRequest($this->getHttpClient(), $this->getHttpRequest());

        $options = [
            'apiKey' => 'someApiKey',
        ];

        $this->request = $request->initialize($options);
        $this->options = $options;
    }


    /** @test */
    public function it_gets_the_correct_data_from_the_request()
    {
        $data = $this->request->getData()['data'];

        $this->assertSame($this->options['apiKey'], $data['apikey']);
    }


    /** @test */
    public function it_returns_the_expected_response_type()
    {
        $this->setMockHttpResponse('TypesSuccess.txt');

        $response = $this->request->send();

        $this->assertInstanceOf('Omnipay\Secupay\Message\Response', $response);
    }
}
