<?php

namespace Omnipay\Secupay\Message;

/**
 * Secupay Void Request
 */
class VoidRequest extends AbstractRequest
{
    protected $namespace = 'payment';
    protected $action = 'void';

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
