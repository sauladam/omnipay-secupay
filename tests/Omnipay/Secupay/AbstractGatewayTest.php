<?php

namespace Omnipay\Secupay;

use Omnipay\Tests\GatewayTestCase;

abstract class AbstractGatewayTest extends GatewayTestCase
{

    /**
     * @var KKGateway|LSGateway
     */
    protected $gateway;


    /** @test */
    public function it_creates_an_authorize_request_correctly()
    {
        $request = $this->gateway->authorize();
        $this->assertInstanceOf('Omnipay\Secupay\Message\InitRequest', $request);

    }


    /** @test */
    public function it_creates_a_capture_request_correctly()
    {
        $request = $this->gateway->capture();
        $this->assertInstanceOf('Omnipay\Secupay\Message\CaptureRequest', $request);
    }


    /** @test */
    public function it_creates_a_complete_purchase_request_correctly()
    {
        $request = $this->gateway->completePurchase();
        $this->assertInstanceOf('Omnipay\Secupay\Message\CompletePurchaseRequest', $request);
    }


    /** @test */
    public function it_creates_a_purchase_request_correctly()
    {
        $request = $this->gateway->purchase();
        $this->assertInstanceOf('Omnipay\Secupay\Message\PurchaseRequest', $request);
    }


    /** @test */
    public function it_creates_a_status_request_correctly()
    {
        $request = $this->gateway->status();
        $this->assertInstanceOf('Omnipay\Secupay\Message\StatusRequest', $request);
    }


    /** @test */
    public function it_creates_a_types_request_correctly()
    {
        $request = $this->gateway->types();
        $this->assertInstanceOf('Omnipay\Secupay\Message\TypesRequest', $request);
    }


    /** @test */
    public function it_creates_a_void_request_correctly()
    {
        $request = $this->gateway->void();
        $this->assertInstanceOf('Omnipay\Secupay\Message\VoidRequest', $request);
    }
}
