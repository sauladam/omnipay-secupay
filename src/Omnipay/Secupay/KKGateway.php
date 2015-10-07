<?php

namespace Omnipay\Secupay;

class KKGateway extends AbstractSecupayGateway
{

    /**
     * Get the gateway name.
     *
     * @return string
     */
    public function getName()
    {
        return 'Secupay Credit Card';
    }


    /**
     * Get the default parameters.
     *
     * @return array
     */
    public function getDefaultParameters()
    {
        $commonParameters = parent::getDefaultParameters();

        $specificParameters = [
            'paymentType' => 'creditcard',
        ];

        return array_merge($commonParameters, $specificParameters);
    }
}
