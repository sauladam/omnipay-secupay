<?php

namespace Omnipay\Secupay\Message;

/**
 * Secupay Capture Request
 */
class CaptureRequest extends AbstractRequest
{
    protected $namespace = 'payment';
    protected $action = 'capture';

    public function getData()
    {
        $this->validate('apiKey', 'hash');

        $data = parent::getBaseData();

        $data['data']['hash'] = $this->getHash();

        return $data;
    }

    public function getEndpoint()
    {
        $endpoint = parent::getEndpoint();
        $hash = $this->getHash();

        return "{$endpoint}/{$this->namespace}/{$hash}/{$this->action}";
    }
}
