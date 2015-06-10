<?php

namespace Omnipay\Secupay\Message;

class StatusResponseTest extends AbstractResponseTest
{

    /** @test */
    public function it_gets_the_expected_data_from_a_successful_status_response()
    {
        $this->setResponse('StatusSuccess');

        $this->isSuccessful();
        $this->hasNoErrors();
        $this->hasTransactionDetails([
            'reference' => 'xthlpleknqvt20214',
            'id'        => '2449700',
            'status'    => 'accepted',
        ]);
    }


    /** @test */
    public function it_gets_the_expected_data_from_a_failed_status_response()
    {
        $this->setResponse('StatusFailure');

        $this->isNotSuccessful();
        $this->hasError('0002', 'Ungültiger hash');
        $this->hasTransactionDetails([ 'reference' => 'stuff' ]);
    }
}
