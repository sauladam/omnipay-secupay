<?php

namespace Omnipay\Secupay\Message;

use Omnipay\Tests\TestCase;

class CaptureRequestTest extends TestCase
{

    /**
     * @var array
     */
    protected $options;

    /**
     * @var CaptureRequest
     */
    protected $request;


    /**
     * Set up the testing environment.
     */
    public function setUp()
    {
        $request = new CaptureRequest($this->getHttpClient(), $this->getHttpRequest());

        $options = [
            'apiKey' => 'someApiKey',
            'hash'   => 'someHash'
        ];

        $this->request = $request->initialize($options);
        $this->options = $options;
    }


    /** @test */
    public function it_gets_the_expected_data_from_the_request()
    {
        $data = $this->request->getData()['data'];

        $this->assertSame($this->options['apiKey'], $data['apikey']);
        $this->assertSame($this->options['hash'], $data['hash']);
    }


    /** @test */
    public function it_adds_the_invoice_number_if_it_is_provided()
    {
        $this->assertNull($this->request->getInvoiceNumber());

        $this->request->setInvoiceNumber('foo');

        $this->assertSame('foo', $this->request->getData()['data']['invoice_number']);
    }


    /** @test */
    public function it_adds_the_tracking_details_if_they_are_provided()
    {
        $this->assertNull($this->request->getTracking());

        $trackingDetails = [
            'provider' => 'DHL',
            'number'   => '12345',
        ];

        $this->request->setTracking($trackingDetails);

        $this->assertSame($trackingDetails, $this->request->getData()['data']['tracking']);
    }


    /**
     * @test
     * @expectedException \Omnipay\Common\Exception\InvalidRequestException
     */
    public function it_squawks_if_the_tracking_details_are_malformed()
    {
        $this->request->setTracking([ 'unknown_key' => 'foo' ]);
        $this->request->setTracking([ 'provider' => 'foo' ]);
        $this->request->setTracking([ 'number' => 'foo' ]);
    }


    /** @test */
    public function it_returns_the_expected_response_type()
    {
        $this->setMockHttpResponse('CaptureSuccess.txt');

        $response = $this->request->send();

        $this->assertInstanceOf('Omnipay\Secupay\Message\Response', $response);
    }
}
