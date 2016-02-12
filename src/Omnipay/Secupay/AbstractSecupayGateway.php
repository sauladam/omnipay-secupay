<?php

namespace Omnipay\Secupay;

use Omnipay\Common\AbstractGateway;

abstract class AbstractSecupayGateway extends AbstractGateway
{

    /**
     * Get the default parameters.
     *
     * @return array
     */
    public function getDefaultParameters()
    {
        return [
            'apiKey'        => '',
            'language'      => 'de_DE',
            'testMode'      => true,
            'useDistSystem' => false,
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
     * Check if the dist system should be used.
     *
     * @return mixed
     */
    public function getUseDistSystem()
    {
        return $this->getParameter('useDistSystem');
    }


    /**
     * Specify whether or not to use the dist system.
     *
     * @param bool $value
     *
     * @return $this
     */
    public function setUseDistSystem($value)
    {
        return $this->setParameter('useDistSystem', $value);
    }


    /**
     * Get the language ISO code 2.
     *
     * @return string
     */
    public function getLanguage()
    {
        return $this->getParameter('language');
    }


    /**
     * Set the language ISO code 2.
     *
     * @param $language
     *
     * @return $this
     */
    public function setLanguage($language)
    {
        return $this->setParameter('language', $language);
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
