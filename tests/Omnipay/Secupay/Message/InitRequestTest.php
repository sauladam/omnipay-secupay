<?php

namespace Omnipay\Secupay\Message;

use Omnipay\Tests\TestCase;

class InitRequestTest extends TestCase
{

    /**
     * @var InitRequest
     */
    protected $request;

    /**
     * @var array
     */
    protected $options;


    /**
     * Set up the test environment.
     */
    public function setUp()
    {
        $request = new InitRequest($this->getHttpClient(), $this->getHttpRequest());

        $options = [
            'apiKey'      => 'someApiKey',
            'paymentType' => 'debit',
            'amount'      => (float) 100,
            'currency'    => 'EUR',
            'urlSuccess'  => 'http://www.test.com/success',
            'urlFailure'  => 'http://www.test.com/failure',
            'urlPush'     => 'http://www.test.com/push',
        ];

        $this->request = $request->initialize($options);
        $this->options = $options;
    }


    /** @test */
    public function it_gets_the_correct_data_from_the_request()
    {
        $data = $this->request->getData()['data'];

        $this->assertSame($this->options['apiKey'], $data['apikey']);
        $this->assertSame($this->options['paymentType'], $data['payment_type']);
        $this->assertSame($this->options['amount'], (float) $data['amount']);
        $this->assertSame($this->options['urlSuccess'], $data['url_success']);
        $this->assertSame($this->options['urlFailure'], $data['url_failure']);
        $this->assertSame($this->options['urlPush'], $data['url_push']);
        $this->assertSame($this->options['currency'], $data['currency']);
    }


    /** @test */
    public function it_gets_the_customer_details_if_they_are_set()
    {
        $this->assertNull($this->request->getCustomerDetails());

        $customerDetails = [
            'address'   => [
                'firstName' => 'Homer',
                'lastName'  => 'Simpson',
                'company'     => 'Fake Inc.', //optional
                'street'      => 'Fakestreet',
                'houseNumber' => '123',
                'zip'         => '12345',
                'city'        => 'Fake City',
                'country'     => 'DE',
            ],
            'title'     => 'Mr.', //optional
            'email'     => 'homer.simpson@springfield.com',
            'phone'     => '123-123456', //optional
            'dob'       => '13.12.2011', //optional
            'ip'        => '123.456.789.012', //optional
        ];

        $this->request->setCustomerDetails($customerDetails);

        $data = $this->request->getData()['data'];

        $this->assertSame($customerDetails['title'], $data['title']);
        $this->assertSame($customerDetails['email'], $data['email']);
        $this->assertSame($customerDetails['phone'], $data['telephone']);
        $this->assertSame($customerDetails['dob'], $data['dob']);
        $this->assertSame($customerDetails['ip'], $data['ip']);

        $address = $customerDetails['address'];
        $this->assertSame($address['firstName'], $data['firstname']);
        $this->assertSame($address['lastName'], $data['lastname']);
        $this->assertSame($address['company'], $data['company']);
        $this->assertSame($address['street'], $data['street']);
        $this->assertSame($address['houseNumber'], $data['housenumber']);
        $this->assertSame($address['zip'], $data['zip']);
        $this->assertSame($address['city'], $data['city']);
        $this->assertSame($address['country'], $data['country']);
    }


    /** @test */
    public function it_adds_the_shop_name_if_one_is_provided()
    {
        $this->assertNull($this->request->getShopName());

        $this->request->setShopName('awesome shop name');

        $data = $this->request->getData();

        $this->assertEquals('awesome shop name', $data['data']['shop']);
    }


    /** @test */
    public function it_sets_the_order_id_if_one_is_provided()
    {
        $this->assertNull($this->request->getOrderId());

        $this->request->setOrderId('order-1234');

        $data = $this->request->getData();

        $this->assertSame('order-1234', $data['data']['order_id']);
    }


    /** @test */
    public function it_sets_the_purpose_if_one_is_provided()
    {
        $this->assertNull($this->request->getPurpose());

        $this->request->setPurpose('some purpose');

        $data = $this->request->getData();

        $this->assertSame('some purpose', $data['data']['purpose']);
    }


    /** @test */
    public function it_adds_the_custom_fields_if_any_are_provided()
    {
        $this->assertNull($this->request->getCustomFields());

        $customFields = [
            'some',
            'custom',
            'fields',
        ];

        $this->request->setCustomFields($customFields);

        $data = $this->request->getData()['data'];

        $this->assertSame($customFields[0], $data['userfields']['userfield_1']);
        $this->assertSame($customFields[1], $data['userfields']['userfield_2']);
        $this->assertSame($customFields[2], $data['userfields']['userfield_3']);
    }


    /** @test */
    public function it_sets_the_delivery_address_if_one_is_provided()
    {
        $this->assertNull($this->request->getDeliveryAddress());

        $deliveryAddress = [
            'firstName'   => 'Marge',
            'lastName'    => 'Simpson',
            'company'     => 'Kwik-E',
            'street'      => 'Evergreen Terrace',
            'houseNumber' => '457',
            'zip'         => '12345',
            'city'        => 'Springfield',
            'country'     => 'US',
        ];

        $this->request->setDeliveryAddress($deliveryAddress);

        $data = $this->request->getData()['data'];

        $this->assertSame($deliveryAddress['firstName'], $data['delivery_address']['firstname']);
        $this->assertSame($deliveryAddress['lastName'], $data['delivery_address']['lastname']);
        $this->assertSame($deliveryAddress['company'], $data['delivery_address']['company']);
        $this->assertSame($deliveryAddress['street'], $data['delivery_address']['street']);
        $this->assertSame($deliveryAddress['houseNumber'], $data['delivery_address']['housenumber']);
        $this->assertSame($deliveryAddress['zip'], $data['delivery_address']['zip']);
        $this->assertSame($deliveryAddress['city'], $data['delivery_address']['city']);
        $this->assertSame($deliveryAddress['country'], $data['delivery_address']['country']);
    }

    /**
     * @test
     * @expectedException \Omnipay\Common\Exception\InvalidRequestException
     */
    public function it_throws_an_exception_if_the_amount_is_invalid()
    {
        $this->request->setAmount(12.3);
    }

    /** @test */
    public function it_returns_the_expected_response_type()
    {
        $this->setMockHttpResponse('InitSuccess.txt');

        $response = $this->request->send();

        $this->assertInstanceOf('Omnipay\Secupay\Message\Response', $response);
    }
}
