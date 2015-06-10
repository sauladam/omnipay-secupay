<?php

namespace Omnipay\Secupay\Message;

class PurchaseResponseTest extends AbstractResponseTest
{

    /** @test */
    public function it_gets_the_expected_data_from_a_successful_purchase_response()
    {
        $this->setResponse('PurchaseSuccess');

        $this->isSuccessful();
        $this->hasNoErrors();
        $this->hasTransactionDetails([ 'reference' => 'wuyluuriqeqy20205' ]);

        $iframeUrl = 'https://api-dist.secupay-ag.de/payment/wuyluuriqeqy20205';
        $this->assertSame($iframeUrl, $this->response->getIframeUrl());
    }


    /** @test */
    public function it_gets_the_expected_data_from_a_failed_purchase_response()
    {
        $this->setResponse('PurchaseFailure');

        $this->isNotSuccessful();
        $this->hasError('0001', 'Ungültiger apikey');
        $this->hasNoTransactionDetails();
        $this->assertNull($this->response->getIframeUrl());
    }
}
