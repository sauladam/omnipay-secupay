<?php

namespace Omnipay\Secupay\Message;

/**
 * Secupay Status Request
 */
class StatusRequest extends AbstractRequest
{
    protected $namespace = 'payment';
    protected $action = 'status';

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

        return "{$endpoint}/{$this->namespace}/{$this->action}";
    }
}
