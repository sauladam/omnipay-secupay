<?php

namespace Omnipay\Secupay\Message;

class VoidResponseTest extends AbstractResponseTest
{

    /** @test */
    public function it_gets_the_expected_data_from_a_successful_void_response()
    {
        $this->setResponse('VoidSuccess');

        $this->isSuccessful();
        $this->hasNoErrors();
        $this->hasTransactionDetails([ 'id' => '2449737' ]);
    }


    /** @test */
    public function it_gets_the_expected_data_from_a_failed_void_response()
    {
        $this->setResponse('VoidFailure');

        $this->isNotSuccessful();
        $this->hasError('0008', 'Hash wurde schon verarbeitet');
        $this->hasNoTransactionDetails();
    }
}
