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

        $this->assertNull($this->response->getPaymentInstructions());
    }


    /** @test */
    public function it_gets_the_expected_data_from_a_failed_status_response()
    {
        $this->setResponse('StatusFailure');

        $this->isNotSuccessful();
        $this->hasError('0002', 'Ungültiger hash');
        $this->hasTransactionDetails([ 'reference' => 'stuff' ]);
    }


    /** @test */
    public function it_gets_the_payment_details_if_they_are_present_for_a_not_yet_shipped_order()
    {
        $this->setResponse('InvoiceStatusSuccessNotShipped');

        $this->isSuccessful();
        $this->hasNoErrors();
        $this->hasTransactionDetails([
            'reference'            => 'cljlldnhgtwh1028319',
            'id'                   => '6297254',
            'status'               => 'accepted',
            'payment_instructions' => [
                'recipient_legal'       => 'secupay AG, Goethestraße 6, 01896 Pulsnitz',
                'payment_link'          => 'https://api.secupay.ag/payment/cljlldnhgtwh1028319',
                'payment_qr_image_url'  => 'https://api.secupay.ag/qr?d=https%3A%2F%2Fapi.secupay.ag%2Fpayment%2Fcljlldnhgtwh1028319',
                'transfer_payment_data' => [
                    'purpose'        => 'TA 6297254 DT 20160212',
                    'account_owner'  => 'Secupay AG',
                    'iban'           => 'DE75 3005 0000 7060 5049 53',
                    'bic'            => 'WELADEDDXXX',
                    'account_number' => '7060504953',
                    'bank_code'      => '30050000',
                    'bank_name'      => 'Landesbank Hessen-Thüringen Girozentrale NL. Düsseldorf',
                ],
                'invoice_number'        => null,
                'shipped'               => false,
                'shipping_date'         => null,
            ],
        ]);
    }


    /** @test */
    public function it_gets_the_payment_details_if_they_are_present_for_a_shipped_order()
    {
        $this->setResponse('InvoiceStatusSuccessShipped');

        $this->isSuccessful();
        $this->hasNoErrors();
        $this->hasTransactionDetails([
            'reference'            => 'qviegjtvuovi1028381',
            'id'                   => '6297346',
            'status'               => 'accepted',
            'payment_instructions' => [
                'recipient_legal'       => 'secupay AG, Goethestraße 6, 01896 Pulsnitz',
                'payment_link'          => 'https://api.secupay.ag/payment/qviegjtvuovi1028381',
                'payment_qr_image_url'  => 'https://api.secupay.ag/qr?d=https%3A%2F%2Fapi.secupay.ag%2Fpayment%2Fqviegjtvuovi1028381',
                'transfer_payment_data' => [
                    'purpose'        => 'TA 6297346 DT 20160212',
                    'account_owner'  => 'Secupay AG',
                    'iban'           => 'DE75 3005 0000 7060 5049 53',
                    'bic'            => 'WELADEDDXXX',
                    'account_number' => '7060504953',
                    'bank_code'      => '30050000',
                    'bank_name'      => 'Landesbank Hessen-Thüringen Girozentrale NL. Düsseldorf',
                ],
                'invoice_number'        => 'invoice-56bdfd0a27d99',
                'shipped'               => true,
                'shipping_date'         => '2016-02-12 16:40:58',
            ]
        ]);
    }
}
