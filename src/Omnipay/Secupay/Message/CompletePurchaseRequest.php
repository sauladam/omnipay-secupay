<?php

namespace Omnipay\Secupay\Message;

class CompletePurchaseRequest extends AbstractRequest
{

    /**
     * @var string
     */
    protected $namespace = 'payment';


    /**
     * Get the data for the request.
     *
     * @return array
     * @throws \Omnipay\Common\Exception\InvalidRequestException
     */
    public function getData()
    {
        $this->validate('apiKey', 'iframeUrl');

        return $this->getBaseData();
    }


    /**
     * Get the iframe URL.
     *
     * @return null|string
     */
    public function getIframeUrl()
    {
        return $this->getParameter('iframeUrl');
    }


    /**
     * Set the iframe URL.
     *
     * @param string $value
     *
     * @return $this
     */
    public function setIframeUrl($value)
    {
        return $this->setParameter('iframeUrl', $value);
    }


    /**
     * Get the endpoint URL for the request.
     *
     * @return null|string
     */
    public function getEndpoint()
    {
        return $this->getIframeUrl();
    }
}
