<?php

namespace Omnipay\Secupay;

class InvoiceGateway extends AbstractSecupayGateway
{

    /**
     * Get the gateway name.
     *
     * @return string
     */
    public function getName()
    {
        return 'Secupay Invoice';
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
            'paymentType' => 'invoice',
        ];

        return array_merge($commonParameters, $specificParameters);
    }
}
