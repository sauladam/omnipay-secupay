<?php

namespace Omnipay\Secupay\Message;

use Omnipay\Tests\TestCase;

abstract class AbstractResponseTest extends TestCase
{

    /**
     * @var Response
     */
    public $response;


    /**
     * Set the response instance from the given name.
     *
     * @param $responseName
     */
    public function setResponse($responseName)
    {
        $httpResponse = $this->getMockHttpResponse($responseName . '.txt');

        $this->response = new Response($this->getMockRequest(), $httpResponse->json());
    }


    /**
     * Make sure that the given response is successful.
     *
     * @param bool $redirect
     */
    public function isSuccessful($redirect = false)
    {
        $this->assertTrue($this->response->isSuccessful());
        $this->assertSame($redirect, $this->response->isRedirect());
        $this->assertSame('ok', $this->response->getStatus());
        $this->assertNotNull($this->response->getRaw());
    }


    /**
     * Make sure that the given response is successful and a redirect.
     */
    public function isSuccessfulAndRedirect()
    {
        $this->isSuccessful(true);
    }


    /**
     * Make sure the given response is not successful.
     *
     * @param string $status
     */
    public function isNotSuccessful($status = 'failed')
    {
        $this->assertFalse($this->response->isSuccessful());
        $this->assertFalse($this->response->isRedirect());
        $this->assertSame($status, $this->response->getStatus());
    }


    /**
     * Make sure the given response has no error data set.
     */
    public function hasNoErrors()
    {
        $this->assertNull($this->response->getMessage());
        $this->assertNull($this->response->getErrorCode());
        $this->assertNull($this->response->getErrors());
    }


    /**
     * Make sure the request has an error with the given error code
     * and error message.
     *
     * @param          $errorCode
     * @param          $errorMessage
     */
    public function hasError($errorCode, $errorMessage)
    {
        $this->assertSame($errorCode, $this->response->getErrorCode());
        $this->assertContains($errorMessage, $this->response->getMessage());
        $this->assertNotNull($this->response->getErrors());
    }


    /**
     * Make sure the the response has the given transaction details.
     *
     * @param array $details
     */
    public function hasTransactionDetails(array $details)
    {
        $default = [
            'reference'            => null,
            'id'                   => null,
            'status'               => null,
            'payment_instructions' => null,
        ];

        $details = array_merge($default, $details);

        $this->assertSame($details['reference'], $this->response->getTransactionReference());
        $this->assertSame($details['id'], $this->response->getTransactionId());
        $this->assertSame($details['status'], $this->response->getTransactionStatus());
        $this->assertSame($details['payment_instructions'], $this->response->getPaymentInstructions());
    }


    /**
     * Make sure the given response has no transaction details.
     */
    public function hasNoTransactionDetails()
    {
        $this->hasTransactionDetails([ ]);
    }
}
