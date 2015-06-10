<?php

namespace Omnipay\Secupay\Message;

class InitResponseTest extends AbstractResponseTest
{

    /** @test */
    public function it_gets_the_expected_data_from_a_successful_init_response()
    {
        $this->setResponse('InitSuccess');

        $this->isSuccessful();
        $this->hasNoErrors();
        $this->hasTransactionDetails([ 'reference' => 'spnzpmtwoeby20160' ]);

        $iframeUrl = 'https://api-dist.secupay-ag.de/payment/spnzpmtwoeby20160';
        $this->assertSame($iframeUrl, $this->response->getIframeUrl());
    }


    /** @test */
    public function it_gets_the_expected_data_from_a_failed_init_response()
    {
        $this->setResponse('InitFailure');

        $this->isNotSuccessful();
        $this->hasError('0001', 'Ungültiger apikey');
        $this->hasNoTransactionDetails();
        $this->assertNull($this->response->getIframeUrl());
    }
}
