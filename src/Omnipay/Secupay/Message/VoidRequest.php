<?php

namespace Omnipay\Secupay\Message;

class VoidRequest extends AbstractRequest
{

    /**
     * @var string
     */
    protected $namespace = 'payment';

    /**
     * @var string
     */
    protected $action = 'void';


    /**
     * Get the data for the request.
     *
     * @return array
     * @throws \Omnipay\Common\Exception\InvalidRequestException
     */
    public function getData()
    {
        $this->validate('apiKey', 'hash');

        $data = parent::getBaseData();

        $data['data']['hash'] = $this->getHash();

        return $data;
    }


    /**
     * Get the endpoint URL for the request.
     *
     * @return string
     */
    public function getEndpoint()
    {
        $endpoint = parent::getEndpoint();
        $hash     = $this->getHash();

        return "{$endpoint}/{$this->namespace}/{$hash}/{$this->action}";
    }
}
