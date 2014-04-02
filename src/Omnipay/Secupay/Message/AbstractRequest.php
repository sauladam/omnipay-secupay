<?php

namespace Omnipay\Secupay\Message;

/**
 * Secupay Abstract Request
 */
abstract class AbstractRequest extends \Omnipay\Common\Message\AbstractRequest
{
	const API_VERSION = '2.3.9';

    protected $liveEndpoint = 'https://api.secupay.ag';
    protected $testEndpoint = 'https://api-dist.secupay-ag.de';

    public function getApiKey()
    {
        return $this->getParameter('apiKey');
    }

    public function setApiKey($value)
    {
        return $this->setParameter('apiKey', $value);
    }

    public function getPaymentType()
    {
        return $this->getParameter('paymentType');
    }

    public function setPaymentType($value)
    {
        return $this->setParameter('paymentType', $value);
    }    

    public function getHash()
    {
        return $this->getParameter('hash');
    }

    public function setHash($value)
    {
        return $this->setParameter('hash', $value);
    }

    public function getUrlSuccess()
    {
        return $this->getParameter('urlSuccess');
    }

    public function setUrlSuccess($value)
    {
        return $this->setParameter('urlSuccess', $value);
    }

    public function getUrlFailure()
    {
        return $this->getParameter('urlFailure');
    }

    public function setUrlFailure($value)
    {
        return $this->setParameter('urlFailure', $value);
    }

    public function getUrlPush()
    {
        return $this->getParameter('urlPush');
    }

    public function setUrlPush($value)
    {
        return $this->setParameter('urlPush', $value);
    }

    public function getPaymentData()
    {
        return $this->getParameter('paymentData');
    }

    public function setPaymentData($value)
    {
        return $this->setParameter('paymentData', $value);
    }

    public function getIframeUrl()
    {
        return $this->getParameter('iframeUrl');
    }

    public function setIframeUrl($value)
    {
        return $this->setParameter('iframeUrl', $value);
    }

    public function getBaseData()
    {
        return array(
            'data' => array(
                'apikey' => $this->getApiKey(),
            )
        );
    }

    protected function getEndpoint()
    {
        return $this->getTestMode() ? $this->testEndpoint : $this->liveEndpoint;
    }

    protected function getDemoValue()
    {
        return $this->getTestMode() ? '1' : '0';
    }

    public function setAmount($value)
    {
        $biassed = $value != (int)$value;

        if($biassed)
        {
            throw new \Omnipay\Common\Exception\InvalidRequestException('The amount must be give in the smallest currency-unit!');
        }

        return $this->setParameter('amount', (int) $value);
    }

    public function getAmount()
    {   
        return $this->getParameter('amount');
    }

    public function sendData($data)
    {
        $url = $this->getEndpoint();

        $data = json_encode($data);

        $httpResponse = $this->httpClient->post($url, null, $data)->send();

        return $this->createResponse($httpResponse->json());
    }

    protected function createResponse($data)
    {
        return $this->response = new Response($this, $data);
    }
}
