<?php

namespace Omnipay\Secupay\Message;

class PurchaseRequestTest extends InitRequestTest
{

    /**
     * @var PurchaseRequest
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
        parent::setUp();

        $request = new PurchaseRequest($this->getHttpClient(), $this->getHttpRequest());

        $options = array_merge($this->options, [
            'paymentData' => [
                'accountOwner'  => 'Some Guy',
                'accountNumber' => '123456',
                'bankCode'      => '654321',
            ]
        ]);

        $this->request = $request->initialize($options);
        $this->options = $options;
    }


    /** @test */
    public function it_gets_the_purchase_specific_data_correctly()
    {
        $data = $this->request->getData()['data'];

        $this->assertSame($this->options['paymentData']['accountOwner'], $data['payment_data']['accountowner']);
        $this->assertSame($this->options['paymentData']['accountNumber'], $data['payment_data']['accountnumber']);
        $this->assertSame($this->options['paymentData']['bankCode'], $data['payment_data']['bankcode']);
    }


    /** @test */
    public function it_returns_the_expected_response_type()
    {
        $this->setMockHttpResponse('PurchaseSuccess.txt');

        $response = $this->request->send();

        $this->assertInstanceOf('Omnipay\Secupay\Message\Response', $response);
    }
}
