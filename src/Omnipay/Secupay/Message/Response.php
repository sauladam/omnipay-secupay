<?php

namespace Omnipay\Secupay\Message;

use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\RequestInterface;

class Response extends AbstractResponse
{

    /**
     * @var RequestInterface
     */
    protected $request;

    /**
     * @var array
     */
    protected $data;


    /**
     * Create a new Response instance.
     *
     * @param RequestInterface $request
     * @param                  $data
     */
    public function __construct(RequestInterface $request, $data)
    {
        $this->request = $request;
        $this->data    = $data;
    }


    /**
     * Get the raw data.
     *
     * @return array
     */
    public function getRaw()
    {
        return $this->data;
    }


    /**
     * Get only the 'data'-portion of the response-data.
     *
     * @return mixed
     */
    public function getData()
    {
        return $this->data['data'];
    }


    /**
     * Get the errors.
     *
     * @return array
     */
    public function getErrors()
    {
        return $this->data['errors'];
    }


    /**
     * Get the status.
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->data['status'];
    }


    /**
     * Check if the request was successful.
     *
     * @return bool
     */
    public function isSuccessful()
    {
        return $this->data['status'] === 'ok';
    }


    /**
     * Get the transaction reference.
     *
     * @return null|string
     */
    public function getTransactionReference()
    {
        if (isset($this->data['data']['hash'])) {
            return $this->data['data']['hash'];
        }

        return null;
    }


    /**
     * Get the transaction ID.
     *
     * @return null|string
     */
    public function getTransactionId()
    {
        /**
         * This is an internal transaction reference and not
         * a reference for the API-communication
         */
        if (isset($this->data['data']['trans_id'])) {
            return $this->data['data']['trans_id'];
        }

        return null;
    }


    /**
     * Get the transaction status.
     *
     * @return null|string
     */
    public function getTransactionStatus()
    {
        if (isset($this->data['data']['status'])) {
            return $this->data['data']['status'];
        }

        return null;
    }


    /**
     * Get the Ifram URL.
     *
     * @return null|string
     */
    public function getIframeUrl()
    {
        if (isset($this->data['data']['iframe_url'])) {
            return $this->data['data']['iframe_url'];
        }

        return null;
    }


    /**
     * Get the error message.
     *
     * @return null|string
     */
    public function getMessage()
    {
        if (null !== $this->data['errors']) {
            return $this->data['errors'][0]['message'];
        }

        return null;
    }


    /**
     * Get the error code.
     *
     * @return null|string
     */
    public function getErrorCode()
    {
        if (null !== $this->data['errors']) {
            return $this->data['errors'][0]['code'];
        }

        return null;
    }
}
