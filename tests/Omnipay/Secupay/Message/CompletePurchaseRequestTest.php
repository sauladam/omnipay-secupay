<?php

namespace Omnipay\Secupay\Message;

use Omnipay\Tests\TestCase;

class CompletePurchaseRequestTest extends TestCase
{

    /**
     * @var CompletePurchaseRequest
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
        $request = new CompletePurchaseRequest($this->getHttpClient(), $this->getHttpRequest());

        $options = [
            'apiKey'    => 'someApiKey',
            'iframeUrl' => 'https://api-dist.secupay-ag.de/payment/ejwyhqidngzu20208',
        ];

        $this->request = $request->initialize($options);
        $this->options = $options;
    }


    /** @test */
    public function it_returns_the_expected_response_type()
    {
        $this->setMockHttpResponse('CompletePurchaseSuccess.txt');

        $response = $this->request->send();

        $this->assertInstanceOf('Omnipay\Secupay\Message\Response', $response);
    }
}
