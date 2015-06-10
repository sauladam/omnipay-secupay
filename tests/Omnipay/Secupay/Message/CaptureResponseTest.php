<?php

namespace Omnipay\Secupay\Message;

class CaptureResponseTest extends AbstractResponseTest
{

    /** @test */
    public function it_gets_the_expected_data_from_a_successful_response()
    {
        $this->setResponse('CaptureSuccess');

        $this->isSuccessful();
        $this->hasNoErrors();
        $this->hasTransactionDetails([
            'reference' => 'vcikqjglpdti20245',
            'id'        => '2449731',
            'status'    => 'ok',
        ]);
    }


    /** @test */
    public function it_gets_the_expected_data_from_a_failed_response()
    {
        $this->setResponse('CaptureFailure');

        $this->isNotSuccessful();
        $this->hasError('0014', 'Zahlung konnte nicht abgeschlossen werden');
        $this->hasTransactionDetails([
            'reference' => 'bzymhauuszgf20241',
            'id'        => null,
            'status'    => null,
        ]);
    }
}
