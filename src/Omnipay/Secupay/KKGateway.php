<?php

namespace Omnipay\Secupay;

/**
 * Secupay credit card  payment class
 */
class KKGateway extends AbstractSecupayGateway
{
    public function getName()
    {
        return 'Secupay Credit Card';
    }

    public function getDefaultParameters()
    {
        $commonParameters = parent::getDefaultParameters();

        $specificParameters = array(
            'paymentType' => 'creditcard',
            'testMode' => true,
        );

        return array_merge($commonParameters, $specificParameters);
    }
}
