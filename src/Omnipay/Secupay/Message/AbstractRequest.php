<?php

namespace Omnipay\Secupay\Message;

abstract class AbstractRequest extends \Omnipay\Common\Message\AbstractRequest
{

    const API_VERSION = '2.3.9';

    /**
     * @var string
     */
    protected $liveEndpoint = 'https://api.secupay.ag';

    /**
     * @var string
     */
    protected $distEndpoint = 'https://api-dist.secupay-ag.de';


    /**
     * Get the API key.
     *
     * @return string
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
     * @return string
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
     * Get the transaction reference hash.
     *
     * @return string
     */
    public function getHash()
    {
        return $this->getParameter('hash');
    }


    /**
     * Set the transaction reference hash.
     *
     * @param string $value
     *
     * @return $this
     */
    public function setHash($value)
    {
        return $this->setParameter('hash', $value);
    }


    /**
     * Get the common base data for each request.
     *
     * @return array
     */
    public function getBaseData()
    {
        return [
            'data' => [
                'apikey' => $this->getApiKey(),
            ]
        ];
    }


    /**
     * Get the endpoint URL for the request.
     *
     * @return string
     */
    protected function getEndpoint()
    {
        return $this->getUseDistSystem()
            ? $this->distEndpoint
            : $this->liveEndpoint;
    }


    /**
     * Get the value indicating if the gateway is in
     * test or in production mode.
     *
     * @return string
     */
    protected function getDemoValue()
    {
        return $this->getTestMode()
            ? '1'
            : '0';
    }


    /**
     * Send the request with the given data.
     *
     * @param array $data
     *
     * @return Response
     */
    public function sendData($data)
    {
        $url = $this->getEndpoint();

        $data = json_encode($data);

        $httpResponse = $this->httpClient->post($url, null, $data)->send();

        return $this->createResponse($httpResponse->json());
    }


    /**
     * Create the response.
     *
     * @param array $data
     *
     * @return Response
     */
    protected function createResponse($data)
    {
        return $this->response = new Response($this, $data);
    }
}
