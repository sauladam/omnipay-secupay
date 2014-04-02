<?php

namespace Omnipay\Secupay;

use Omnipay\Tests\GatewayTestCase;
use Guzzle\Http\ClientInterface;
use Guzzle\Http\Client as HttpClient;

class KKGatewayTest extends GatewayTestCase
{

    public function setUp()
    {
        parent::setUp();

        $this->gateway = new KKGateway($this->getHttpClient(), $this->getHttpRequest());
    }

    /**
     * @expectedException \Omnipay\Common\Exception\InvalidRequestException
     */
    public function testThrowsExceptionOnInvalidAmount()
    {
        $request = $this->gateway->authorize();
        $request->setAmount(12.3);
    }

    public function testAuthorize()
    {
        $options = array(
            'apiKey' => 'someApiKey',
            'amount' => 100,
            'currency' => 'EUR',
            'urlSuccess' => 'http://www.test.com/success',
            'urlFailure' => 'http://www.test.com/failure',
            'urlPush' => 'http://www.test.com/push',
        );

        $request = $this->gateway->authorize($options);

        $this->assertInstanceOf('Omnipay\Secupay\Message\InitRequest', $request);

        $this->assertSame($options['apiKey'], $request->getApiKey());
        $this->assertSame($options['amount'], $request->getAmount());
        $this->assertSame($options['currency'], $request->getCurrency());
        $this->assertSame($options['urlSuccess'], $request->getUrlSuccess());
        $this->assertSame($options['urlFailure'], $request->getUrlFailure());
        $this->assertSame($options['urlPush'], $request->getUrlPush());
        $this->assertTrue($request->getTestMode());
    }

    public function testCapture()
    {
        $options = array(
            'apiKey' => 'someApiKey',
            'hash' => 'someHash',
        );

        $request = $this->gateway->capture($options);

        $this->assertInstanceOf('Omnipay\Secupay\Message\CaptureRequest', $request);

        $this->assertSame($options['apiKey'], $request->getApiKey());
        $this->assertSame($options['hash'], $request->getHash());
        $this->assertTrue($request->getTestMode());
    }

    public function testCompletePurchase()
    {
        $options = array(
            'apiKey' => 'someApiKey',
            'iframeUrl' => 'https://api-dist.secupay-ag.de/payment/ejwyhqidngzu20208',
        );

        $request = $this->gateway->completePurchase($options);

        $this->assertInstanceOf('Omnipay\Secupay\Message\CompletePurchaseRequest', $request);

        $this->assertSame($options['apiKey'], $request->getApiKey());
        $this->assertSame('https://api-dist.secupay-ag.de/payment/ejwyhqidngzu20208', $request->getIframeUrl());
        $this->assertSame('https://api-dist.secupay-ag.de/payment/ejwyhqidngzu20208', $request->getEndpoint());
        $this->assertTrue($request->getTestMode());
    }

    public function testPurchase()
    {
        $options = array(
            'apiKey' => 'someApiKey',
            'amount' => 100,
            'currency' => 'EUR',
            'urlSuccess' => 'http://www.test.com/success',
            'urlFailure' => 'http://www.test.com/failure',
            'urlPush' => 'http://www.test.com/push',
            'paymentData' => array(
                'accountowner' => 'Random Dude',
                'accountnumber' => '123456',
                'bankcode' => '654321',
            ),
        );

        $request = $this->gateway->purchase($options);

        $this->assertInstanceOf('Omnipay\Secupay\Message\PurchaseRequest', $request);

        $this->assertSame($options['apiKey'], $request->getApiKey());
        $this->assertSame($options['amount'], $request->getAmount());
        $this->assertSame($options['currency'], $request->getCurrency());
        $this->assertSame($options['urlSuccess'], $request->getUrlSuccess());
        $this->assertSame($options['urlFailure'], $request->getUrlFailure());
        $this->assertSame($options['urlPush'], $request->getUrlPush());
        $this->assertSame($options['paymentData'], $request->getPaymentData());
        $this->assertTrue($request->getTestMode());
    }

    public function testStatus()
    {
        $options = array(
            'apiKey' => 'someApiKey',
            'hash' => 'someHash',
        );

        $request = $this->gateway->status($options);

        $this->assertInstanceOf('Omnipay\Secupay\Message\StatusRequest', $request);

        $this->assertSame($options['apiKey'], $request->getApiKey());
        $this->assertSame($options['hash'], $request->getHash());
        $this->assertTrue($request->getTestMode());
    }

    public function testTypes()
    {
        $options = array(
            'apiKey' => 'someApiKey',
        );

        $request = $this->gateway->types($options);

        $this->assertInstanceOf('Omnipay\Secupay\Message\TypesRequest', $request);

        $this->assertSame($options['apiKey'], $request->getApiKey());
        $this->assertTrue($request->getTestMode());
    }

    public function testVoid()
    {
        $options = array(
            'apiKey' => 'someApiKey',
            'hash' => 'someHash',
        );

        $request = $this->gateway->void($options);

        $this->assertInstanceOf('Omnipay\Secupay\Message\VoidRequest', $request);

        $this->assertSame($options['apiKey'], $request->getApiKey());
        $this->assertSame($options['hash'], $request->getHash());
        $this->assertTrue($request->getTestMode());
    }
    
}
