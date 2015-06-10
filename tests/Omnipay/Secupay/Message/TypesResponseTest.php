<?php

namespace Omnipay\Secupay\Message;

class TypesResponseTest extends AbstractResponseTest
{

    /** @test */
    public function it_gets_the_expected_data_from_a_successful_types_response()
    {
        $this->setResponse('TypesSuccess');

        $this->isSuccessful();
        $this->hasNoErrors();
        $this->hasNoTransactionDetails();

        $this->assertContains('debit', $this->response->getData());
        $this->assertContains('creditcard', $this->response->getData());
    }


    /** @test */
    public function it_gets_the_expected_data_from_a_failed_types_response()
    {
        $this->setResponse('TypesFailure');

        $this->isNotSuccessful('error');
        $this->hasError('0001', 'Ungültiger apikey');
        $this->hasNoTransactionDetails();
    }
}
