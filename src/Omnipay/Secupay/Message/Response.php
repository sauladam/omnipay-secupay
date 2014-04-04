<?php

namespace Omnipay\Secupay\Message;

use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\RequestInterface;

/**
 * Secupay Response
 */
class Response extends AbstractResponse
{
    protected $request;
    protected $data;

    public function __construct(RequestInterface $request, $data)
    {
        $this->request = $request;
        $this->data = $data;
    }

    public function getRaw()
    {
        return $this->data;
    }

    public function getData()
    {
        return $this->data['data'];
    }

    public function getErrors()
    {
        return $this->data['errors'];
    }

    public function getStatus()
    {
        return $this->data['status'];
    }

    public function isSuccessful()
    {
        return $this->data['status'] === 'ok';
    }

    public function getTransactionReference()
    {
        if (isset($this->data['data']['hash'])) {
            return $this->data['data']['hash'];
        }

        return null;
    }

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

    public function getTransactionStatus()
    {
        if (isset($this->data['data']['status'])) {
            return $this->data['data']['status'];
        }

        return null;
    }

    public function getIframeUrl()
    {
        if (isset($this->data['data']['iframe_url'])) {
            return $this->data['data']['iframe_url'];
        }

        return null;
    }

    public function getMessage()
    {
        if (null !== $this->data['errors']) {
            return $this->data['errors'][0]['message'];
        }

        return null;
    }

    public function getErrorCode()
    {
        if (null !== $this->data['errors']) {
            return $this->data['errors'][0]['code'];
        }

        return null;
    }
}
