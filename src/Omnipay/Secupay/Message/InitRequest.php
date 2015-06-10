<?php

namespace Omnipay\Secupay\Message;

class InitRequest extends AbstractRequest
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
        $this->validate('apiKey', 'paymentType', 'urlSuccess', 'urlFailure');

        $data = parent::getBaseData();

        $data['data']['payment_type'] = $this->getPaymentType();
        $data['data']['demo']         = parent::getDemoValue();
        $data['data']['amount']       = $this->getAmount();
        $data['data']['currency']     = $this->getCurrency();
        $data['data']['url_success']  = $this->getUrlSuccess();
        $data['data']['url_failure']  = $this->getUrlFailure();
        $data['data']['url_push']     = $this->getUrlPush();

        $data['data'] = $this->addCustomerDetails($data['data']);
        $data['data'] = $this->addPurpose($data['data']);
        $data['data'] = $this->addOrderId($data['data']);
        $data['data'] = $this->addDeliveryAddress($data['data']);
        $data['data'] = $this->addShopName($data['data']);
        $data['data'] = $this->addCustomFields($data['data']);

        return $data;
    }


    /**
     * Set the payment amount as the smallest currency unit.
     * The argument must be passed as float though because Omnipay says so.
     *
     * @param float $value
     *
     * @return $this
     * @throws \Omnipay\Common\Exception\InvalidRequestException
     */
    public function setAmount($value)
    {
        $biassed = $value != (int) $value;

        if ($biassed) {
            $message = 'The amount must be give in the smallest currency-unit!';
            throw new \Omnipay\Common\Exception\InvalidRequestException($message);
        }

        return $this->setParameter('amount', (int) $value);
    }


    /**
     * Get the payment amount.
     *
     * @return null|int
     */
    public function getAmount()
    {
        return $this->getParameter('amount');
    }


    /**
     * Get the success callback URL.
     *
     * @return null|string
     */
    public function getUrlSuccess()
    {
        return $this->getParameter('urlSuccess');
    }


    /**
     * Set the success callback URL.
     *
     * @param string $value
     *
     * @return $this
     */
    public function setUrlSuccess($value)
    {
        return $this->setParameter('urlSuccess', $value);
    }


    /**
     * Get the failure callback URL.
     *
     * @return null|string
     */
    public function getUrlFailure()
    {
        return $this->getParameter('urlFailure');
    }


    /**
     * Set the failure callback URL.
     *
     * @param $value
     *
     * @return $this
     */
    public function setUrlFailure($value)
    {
        return $this->setParameter('urlFailure', $value);
    }


    /**
     * Get the push URL.
     *
     * @return null|string
     */
    public function getUrlPush()
    {
        return $this->getParameter('urlPush');
    }


    /**
     * Set the push URL.
     *
     * @param string $value
     *
     * @return $this
     */
    public function setUrlPush($value)
    {
        return $this->setParameter('urlPush', $value);
    }


    /**
     * Get the customer details.
     *
     * @return null|array
     */
    public function getCustomerDetails()
    {
        return $this->getParameter('customerDetails');
    }


    /**
     * Set the customer details.
     *
     * @param array $customerDetails
     *
     * @return $this
     */
    public function setCustomerDetails(array $customerDetails)
    {
        return $this->setParameter('customerDetails', $customerDetails);
    }


    /**
     * Get the payment purpose.
     *
     * @return null|string
     */
    public function getPurpose()
    {
        return $this->getParameter('purpose');
    }


    /**
     * Set the payment purpose.
     *
     * @param string $purpose
     *
     * @return $this
     */
    public function setPurpose($purpose)
    {
        return $this->setParameter('purpose', $purpose);
    }


    /**
     * Get the order ID.
     *
     * @return null|string
     */
    public function getOrderId()
    {
        return $this->getParameter('orderId');
    }


    /**
     * Set the order ID.
     *
     * @param string $orderId
     *
     * @return $this
     */
    public function setOrderId($orderId)
    {
        return $this->setParameter('orderId', $orderId);
    }


    /**
     * Get the delivery address.
     *
     * @return null|array
     */
    public function getDeliveryAddress()
    {
        return $this->getParameter('deliveryAddress');
    }


    /**
     * Set the delivery address.
     *
     * @param array $address
     *
     * @return $this
     */
    public function setDeliveryAddress(array $address)
    {
        return $this->setParameter('deliveryAddress', $address);
    }


    /**
     * Get the shop name.
     *
     * @return null|string
     */
    public function getShopName()
    {
        return $this->getParameter('shopName');
    }


    /**
     * Set the shop name.
     *
     * @param string $name
     *
     * @return $this
     */
    public function setShopName($name)
    {
        return $this->setParameter('shopName', $name);
    }


    /**
     * Get the custom fields.
     *
     * @return null|array
     */
    public function getCustomFields()
    {
        return $this->getParameter('customFields');
    }


    /**
     * Set the custom fields.
     *
     * @param array $customFields
     *
     * @return $this
     */
    public function setCustomFields(array $customFields)
    {
        return $this->setParameter('customFields', $customFields);
    }


    /**
     * Get the endpoint for this request.
     *
     * @return string
     */
    public function getEndpoint()
    {
        $endpoint = parent::getEndpoint();

        return "{$endpoint}/{$this->namespace}/{$this->action}";
    }


    /**
     * Add the customer details to the request data.
     *
     * @param array $data
     *
     * @return array
     */
    protected function addCustomerDetails(array $data)
    {
        $customerDetails = $this->getCustomerDetails();

        if ( ! $customerDetails) {
            return $data;
        }

        $data['firstname'] = $customerDetails['firstName'];
        $data['lastname']  = $customerDetails['lastName'];

        $data['street']      = $customerDetails['address']['street'];
        $data['housenumber'] = $customerDetails['address']['houseNumber'];
        $data['zip']         = $customerDetails['address']['zip'];
        $data['city']        = $customerDetails['address']['city'];
        $data['country']     = $customerDetails['address']['country'];

        if (array_key_exists('phone', $customerDetails)) {
            $data['telephone'] = $customerDetails['phone'];
        }

        $data = $this->addFromArrayIfExists([ 'company' ], $customerDetails['address'], $data);
        $data = $this->addFromArrayIfExists([ 'title', 'email', 'dob', 'ip' ], $customerDetails, $data);

        return $data;
    }


    /**
     * Add the purpose to the request data.
     *
     * @param array $data
     *
     * @return array
     */
    protected function addPurpose(array $data)
    {
        return $this->addFromParameterIfExists('purpose', $data);
    }


    /**
     * Add the order ID to the request data.
     *
     * @param array $data
     *
     * @return array
     */
    protected function addOrderId(array $data)
    {
        return $this->addFromParameterIfExists('orderId', $data, 'order_id');
    }


    /**
     * Add the delivery address to the request data.
     *
     * @param array $data
     *
     * @return array
     */
    protected function addDeliveryAddress(array $data)
    {
        if ( ! $this->getDeliveryAddress()) {
            return $data;
        }

        $data = $this->addFromParameterIfExists('deliveryAddress', $data, 'delivery_address');

        $data['delivery_address'] = array_change_key_case($data['delivery_address'], CASE_LOWER);

        return $data;
    }


    /**
     * Add the shop name to the request data.
     *
     * @param array $data
     *
     * @return array
     */
    protected function addShopName(array $data)
    {
        return $this->addFromParameterIfExists('shopName', $data, 'shop');
    }


    /**
     * Add the custom fields to the request data.
     *
     * @param $data
     *
     * @return array
     */
    protected function addCustomFields(array $data)
    {
        $fields = (array) $this->getCustomFields();

        foreach ($fields as $index => $value) {
            $key                      = 'userfield_' . ( $index + 1 );
            $data['userfields'][$key] = $value;
        }

        return $data;
    }


    /**
     * Add the given parameter to the request data if it's set.
     *
     * @param       $parameterName
     * @param array $data
     * @param null  $overrideName
     *
     * @return array
     */
    protected function addFromParameterIfExists($parameterName, array $data, $overrideName = null)
    {
        $getter    = 'get' . ucfirst($parameterName);
        $parameter = $this->{$getter}();

        if ($parameter) {
            $key = $overrideName ?: $parameterName;

            $data[$key] = $parameter;
        }

        return $data;
    }


    /**
     * Add the values with the given keys from the given array
     * to the request data if they are set.
     *
     * @param array $keys
     * @param array $from
     * @param array $to
     *
     * @return array
     */
    protected function addFromArrayIfExists(array $keys, array $from, array $to)
    {
        foreach ($keys as $key) {
            if (array_key_exists($key, $from)) {
                $to[$key] = $from[$key];
            }
        }

        return $to;
    }
}
