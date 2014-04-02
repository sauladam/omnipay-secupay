<?php

namespace Omnipay\Secupay;

/**
 * Secupay debit payment class
 */
class LSGateway extends AbstractSecupayGateway
{
    public function getName()
    {
        return 'Secupay Debit';
    }

    public function getDefaultParameters()
    {
        $commonParameters = parent::getDefaultParameters();

        $specificParameters = array(
            'paymentType' => 'debit',
            'testMode' => true,
        );

        return array_merge($commonParameters, $specificParameters);
    }
}
