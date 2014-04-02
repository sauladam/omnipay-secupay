<?php

namespace Omnipay\Secupay\Message;

/**
 * Secupay Init / (sort of) authorize Request
 */
class InitRequest extends AbstractRequest
{
    protected $namespace = 'payment';
    protected $action = 'init';

    public function getData()
    {
        $this->validate('apiKey', 'paymentType', 'urlSuccess', 'urlFailure');

        $data = parent::getBaseData();
        
        $data['data']['payment_type'] = $this->getPaymentType();
        $data['data']['demo'] = parent::getDemoValue();
        $data['data']['amount'] = $this->getAmount();
        $data['data']['currency'] = $this->getCurrency();
        $data['data']['url_success'] = $this->getUrlSuccess();
        $data['data']['url_failure'] = $this->getUrlFailure();
        $data['data']['url_push'] = $this->getUrlPush();

        return $data;
    }

    public function getEndpoint()
    {
        $endpoint = parent::getEndpoint();

        return "{$endpoint}/{$this->namespace}/{$this->action}";
    }
}
