<?php

namespace Omnipay\Secupay\Message;

class CaptureRequest extends AbstractRequest
{

    /**
     * @var string
     */
    protected $namespace = 'payment';

    /**
     * @var string
     */
    protected $invoiceAction = 'capture';

    /**
     * @var string
     */
    protected $defaultAction = 'adddata';


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
        $data['data']         = $this->addTracking($data['data']);
        $data['data']         = $this->addInvoiceNumber($data['data']);

        return $data;
    }


    /**
     * Get the invoice number.
     *
     * @return string|null
     */
    public function getInvoiceNumber()
    {
        return $this->getParameter('invoiceNumber');
    }


    /**
     * Set the invoice number.
     *
     * @param $invoiceNumber
     *
     * @return $this
     */
    public function setInvoiceNumber($invoiceNumber)
    {
        return $this->setParameter('invoiceNumber', $invoiceNumber);
    }


    /**
     * Get the tracking details.
     *
     * @return array|null
     */
    public function getTracking()
    {
        return $this->getParameter('tracking');
    }


    /**
     * Set the tracking details.
     *
     * @param array $tracking
     *
     * @return $this
     * @throws \Omnipay\Common\Exception\InvalidRequestException
     */
    public function setTracking(array $tracking)
    {
        if (! array_key_exists('provider', $tracking) || ! array_key_exists('number', $tracking)) {
            $message = "Tracking details must contain a 'provider' and a 'number' key.";
            throw new \Omnipay\Common\Exception\InvalidRequestException($message);
        }

        return $this->setParameter('tracking', $tracking);
    }


    /**
     * Get the endpoint for the request.
     *
     * @return string
     */
    public function getEndpoint()
    {
        $endpoint = parent::getEndpoint();
        $action   = $this->getPaymentType() == 'invoice'
            ? $this->invoiceAction
            : $this->defaultAction;

        return "{$endpoint}/{$this->namespace}/{$action}";
    }


    /**
     * Add the tracking details if they are provided.
     *
     * @param array $data
     *
     * @return array
     */
    protected function addTracking(array $data)
    {
        $trackingDetails = $this->getTracking();

        if ($trackingDetails) {
            $data['tracking'] = $trackingDetails;
        }

        return $data;
    }


    /**
     * Add the invoice number if it is provided.
     *
     * @param array $data
     *
     * @return array
     */
    protected function addInvoiceNumber(array $data)
    {
        $invoiceNumber = $this->getInvoiceNumber();

        if ($invoiceNumber) {
            $data['invoice_number'] = $invoiceNumber;
        }

        return $data;
    }
}
