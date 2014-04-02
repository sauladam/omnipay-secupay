<?php

namespace Omnipay\Secupay\Message;

/**
 * Secupay Types Request
 */
class TypesRequest extends AbstractRequest
{
    protected $namespace = 'payment';
    protected $action = 'gettypes';

    public function getData()
    {
        $this->validate('apiKey');

        return $this->getBaseData();
    }

    public function getEndpoint()
    {
        $endpoint = parent::getEndpoint();

        return "{$endpoint}/{$this->namespace}/{$this->action}";
    }
}
