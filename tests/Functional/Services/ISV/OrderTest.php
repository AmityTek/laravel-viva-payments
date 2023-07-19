<?php

namespace AmityTek\VivaPayments\Test\Functional\Services\ISV;

use GuzzleHttp\Exception\GuzzleException;
use AmityTek\VivaPayments\Facades\Viva;
use AmityTek\VivaPayments\Requests\CreatePaymentOrder;
use AmityTek\VivaPayments\Requests\Customer;
use AmityTek\VivaPayments\Test\TestCase;
use AmityTek\VivaPayments\VivaException;

/**
 * @covers \AmityTek\VivaPayments\Client
 * @covers \AmityTek\VivaPayments\Services\ISV
 * @covers \AmityTek\VivaPayments\Services\ISV\Order
 */
class OrderTest extends TestCase
{
    /**
     * @test
     * @group functional
     * @covers \AmityTek\VivaPayments\Requests\CreatePaymentOrder
     *
     * @throws GuzzleException
     * @throws VivaException
     */
    public function it_creates_an_isv_payment_order(): void
    {
        Viva::withOAuthCredentials(
            strval(env('VIVA_ISV_CLIENT_ID')),
            strval(env('VIVA_ISV_CLIENT_SECRET')),
        );

        $orderCode = Viva::isv()->orders()->create(new CreatePaymentOrder(
            amount: 1000,
            customerTrns: 'Test customer description',
            customer: new Customer(
                email: 'test@vivawallet.com',
                fullName: 'John Doe',
                phone: '+30999999999',
                countryCode: 'GB',
                requestLang: 'en-GB',
            ),
            sourceCode: strval(env('VIVA_SOURCE_CODE')),
            merchantTrns: 'Test merchant description',
            isvAmount: 1,
            resellerSourceCode: 'Default',
        ));

        $this->assertIsNumeric($orderCode);
    }
}
