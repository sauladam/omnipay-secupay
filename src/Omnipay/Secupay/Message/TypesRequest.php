<?php

namespace Omnipay\Secupay\Message;

/**
 * Secupay Types Request
 */
class TypesRequest extends AbstractRequest
{

    /**
     * @var string
     */
    protected $namespace = 'payment';

    /**
     * @var string
     */
    protected $action = 'gettypes';


    /**
     * Get the data for the request.
     *
     * @return array
     * @throws \Omnipay\Common\Exception\InvalidRequestException
     */
    public function getData()
    {
        $this->validate('apiKey');

        return $this->getBaseData();
    }


    /**
     * Get the endpoint URL for the request.
     *
     * @return string
     */
    public function getEndpoint()
    {
        $endpoint = parent::getEndpoint();

        return "{$endpoint}/{$this->namespace}/{$this->action}";
    }
}
