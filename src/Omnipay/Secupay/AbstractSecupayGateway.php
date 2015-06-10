<?php

namespace Omnipay\Secupay;

use Guzzle\Http\Client as HttpClient;
use Omnipay\Common\AbstractGateway;

abstract class AbstractSecupayGateway extends AbstractGateway
{

    /**
     * Create a new gateway instance.
     *
     * We need a custom client because we have to specify
     * a certain User-Agent and a language in the headers, so
     * we have to override the parent constructor.
     *
     */
    public function __construct()
    {
        $client = new HttpClient('', [
            'curl.options' => [
                CURLOPT_CONNECTTIMEOUT => 60,
                CURLOPT_HTTPHEADER     => [
                    'User-Agent: XTC-client 1.0.0',
                    'Accept-Language: de_DE',
                ],
            ],
        ]);

        parent::__construct($client, null);
    }


    /**
     * Get the default parameters.
     *
     * @return array
     */
    public function getDefaultParameters()
    {
        return [
            'apiKey' => '',
        ];
    }


    /**
     * Get the API key.
     *
     * @return null|string
     */
    public function getApiKey()
    {
        return $this->getParameter('apiKey');
    }


    /**
     * Set the API key.
     *
     * @param string $value
     *
     * @return $this
     */
    public function setApiKey($value)
    {
        return $this->setParameter('apiKey', $value);
    }


    /**
     * Get the payment type.
     *
     * @return null|string
     */
    public function getPaymentType()
    {
        return $this->getParameter('paymentType');
    }


    /**
     * Set the payment type.
     *
     * @param string $value
     *
     * @return $this
     */
    public function setPaymentType($value)
    {
        /**
         * The payment type should be immutable / read only.
         */

        return $this->setParameter('paymentType', $value);
    }


    /**
     * Create a types request.
     *
     * @param array $parameters
     *
     * @return \Omnipay\Secupay\Message\TypesRequest
     */
    public function types(array $parameters = [ ])
    {
        return $this->createRequest('\Omnipay\Secupay\Message\TypesRequest', $parameters);
    }


    /**
     * Create an authorize request.
     *
     * @param array $parameters
     *
     * @return \Omnipay\Secupay\Message\InitRequest
     */
    public function authorize(array $parameters = [ ])
    {
        return $this->createRequest('\Omnipay\Secupay\Message\InitRequest', $parameters);
    }


    /**
     * Create a status request.
     *
     * @param array $parameters
     *
     * @return \Omnipay\Secupay\Message\StatusRequest
     */
    public function status(array $parameters = [ ])
    {
        return $this->createRequest('\Omnipay\Secupay\Message\StatusRequest', $parameters);
    }


    /**
     * Create a void request.
     *
     * @param array $parameters
     *
     * @return \Omnipay\Secupay\Message\VoidRequest
     */
    public function void(array $parameters = [ ])
    {
        return $this->createRequest('\Omnipay\Secupay\Message\VoidRequest', $parameters);
    }


    /**
     * Create a capture request.
     *
     * @param array $parameters
     *
     * @return \Omnipay\Secupay\Message\CaptureRequest
     */
    public function capture(array $parameters = [ ])
    {
        return $this->createRequest('\Omnipay\Secupay\Message\CaptureRequest', $parameters);
    }


    /**
     * Create a purchase request.
     *
     * @param array $parameters
     *
     * @return \Omnipay\Secupay\Message\PurchaseRequest
     */
    public function purchase(array $parameters = [ ])
    {
        return $this->createRequest('\Omnipay\Secupay\Message\PurchaseRequest', $parameters);
    }


    /**
     * Create a complete purchase request.
     *
     * @param array $parameters
     *
     * @return \Omnipay\Secupay\Message\CompletePurchaseRequest
     */
    public function completePurchase(array $parameters = [ ])
    {
        return $this->createRequest('\Omnipay\Secupay\Message\CompletePurchaseRequest', $parameters);
    }
}
