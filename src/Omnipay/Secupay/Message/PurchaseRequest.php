<?php

namespace Omnipay\Secupay\Message;

class PurchaseRequest extends InitRequest
{

    /**
     * @var string
     */
    protected $namespace = 'payment';

    /**
     * @var string
     */
    protected $action = 'init';


    /**
     * Get the data for the request.
     *
     * @return array
     * @throws \Omnipay\Common\Exception\InvalidRequestException
     */
    public function getData()
    {
        $this->validate('apiKey', 'paymentData');

        $data = parent::getData();

        $data['data']['payment_data'] = array_change_key_case($this->getPaymentData(), CASE_LOWER);

        return $data;
    }


    /**
     * Get the endpoint for this request.
     *
     * @return string
     */
    public function getEndpoint()
    {
        return parent::getEndpoint();
    }


    /**
     * Get the payment data.
     *
     * @return null|array
     */
    public function getPaymentData()
    {
        return $this->getParameter('paymentData');
    }


    /**
     * Set the payment data.
     *
     * @param array $value
     *
     * @return $this
     */
    public function setPaymentData($value)
    {
        return $this->setParameter('paymentData', $value);
    }
}
