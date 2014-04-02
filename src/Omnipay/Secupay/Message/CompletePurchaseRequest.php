<?php

namespace Omnipay\Secupay\Message;

/**
 * Secupay Complete Purchase Request
 */
class CompletePurchaseRequest extends AbstractRequest
{
    protected $namespace = 'payment';

    public function getData()
    {
        $this->validate('apiKey', 'iframeUrl');

        return $this->getBaseData();
    }

    public function getEndpoint()
    {
        return $this->getIframeUrl();
    }
}
