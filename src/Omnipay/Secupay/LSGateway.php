<?php

namespace Omnipay\Secupay;

class LSGateway extends AbstractSecupayGateway
{

    /**
     * Get the gateway name.
     *
     * @return string
     */
    public function getName()
    {
        return 'Secupay Debit';
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
            'paymentType' => 'debit',
            'testMode' => true,
        ];

        return array_merge($commonParameters, $specificParameters);
    }
}
