<?php

namespace Omnipay\Secupay;

use Guzzle\Http\Client as HttpClient;
use Omnipay\Common\AbstractGateway;

abstract class AbstractSecupayGateway extends AbstractGateway
{
	public function __construct()
    {
        /**
         * We need a custom client because we have to specify
         * a User-Agent and a language.
         */
        $client = new HttpClient(
            '',
            array(
                'curl.options' => array(
                    CURLOPT_CONNECTTIMEOUT => 60, 
                    CURLOPT_HTTPHEADER => array(
                        'User-Agent: XTC-client 1.0.0',
                        'Accept-Language: de_DE',
                    ),
                ),
            )
        );

        parent::__construct($client, null);
    }

	public function getDefaultParameters()
    {
        return array(
            'apiKey' => '',
        );
    }

    public function getApiKey()
    {
        return $this->getParameter('apiKey');
    }

    public function setApiKey($value)
    {
        return $this->setParameter('apiKey', $value);
    }

    public function getPaymentType()
    {
        return $this->getParameter('paymentType');
    }

    public function setPaymentType($value)
    {
        /**
         * The payment type should be immutable / read only.
         */
        return $this->setParameter('paymentType', $value);
    }

    public function types(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Secupay\Message\TypesRequest', $parameters);
    }

    public function authorize(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Secupay\Message\InitRequest', $parameters);
    }

    public function status(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Secupay\Message\StatusRequest', $parameters);
    }

    public function void(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Secupay\Message\VoidRequest', $parameters);
    }

    public function capture(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Secupay\Message\CaptureRequest', $parameters);
    }

    public function purchase(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Secupay\Message\PurchaseRequest', $parameters);
    }

    public function completePurchase(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Secupay\Message\CompletePurchaseRequest', $parameters);
    }    
}
