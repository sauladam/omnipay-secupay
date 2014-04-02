<?php

namespace Omnipay\Secupay\Message;

/**
 * Secupay Purchase Request
 */
class PurchaseRequest extends AbstractRequest
{
    protected $namespace = 'payment';
    protected $action = 'init';

    public function getData()
    {
        $this->validate('apiKey', 'paymentType', 'urlSuccess', 'urlFailure', 'paymentData');

        $data = parent::getBaseData();
        
        $data['data']['payment_type'] = $this->getPaymentType();
        $data['data']['demo'] = parent::getDemoValue();
        $data['data']['amount'] = $this->getAmount();
        $data['data']['currency'] = $this->getCurrency();
        $data['data']['url_success'] = $this->getUrlSuccess();
        $data['data']['url_failure'] = $this->getUrlFailure();
        $data['data']['url_push'] = $this->getUrlPush();
        $data['data']['payment_data'] = $this->getPaymentData();

        return $data;
    }

    public function getEndpoint()
    {
        $endpoint = parent::getEndpoint();

        return "{$endpoint}/{$this->namespace}/{$this->action}";
    }
}
