<?php

namespace Omnipay\Secupay\Message;

class StatusRequest extends AbstractRequest
{

    /**
     * @var string
     */
    protected $namespace = 'payment';

    /**
     * @var string
     */
    protected $action = 'status';


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
     * Get the endpoint for the request.
     *
     * @return string
     */
    public function getEndpoint()
    {
        $endpoint = parent::getEndpoint();

        return "{$endpoint}/{$this->namespace}/{$this->action}";
    }
}
