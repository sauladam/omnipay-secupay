<?php

namespace Omnipay\Secupay\Message;

class CompletePurchaseResponseTest extends AbstractResponseTest
{

    /** @test */
    public function it_gets_the_expected_data_from_a_successful_complete_purchase_response()
    {
        $this->setResponse('CompletePurchaseSuccess');

        $this->isSuccessful();
        $this->hasNoErrors();
        $this->hasTransactionDetails([ 'id' => '2449693' ]);
    }


    /** @test */
    public function it_gets_the_expected_data_from_a_failed_complete_purchase_response()
    {
        $this->setResponse('CompletePurchaseFailure');

        $this->isNotSuccessful();
        $this->hasError('0013', 'Apikey stimmt nicht überein');
        $this->hasNoTransactionDetails();
    }
}
