<?php

namespace AmityTek\VivaPayments\Test\Functional\Services;

use GuzzleHttp\Exception\GuzzleException;
use AmityTek\VivaPayments\Facades\Viva;
use AmityTek\VivaPayments\Requests\CreatePaymentOrder;
use AmityTek\VivaPayments\Requests\Customer;
use AmityTek\VivaPayments\Test\TestCase;
use AmityTek\VivaPayments\VivaException;

/** @covers \AmityTek\VivaPayments\Services\Order */
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
    public function it_creates_a_payment_order(): void
    {
        $orderCode = Viva::orders()->create(new CreatePaymentOrder(
            amount: 1000,
            customerTrns: 'Test customer description',
            customer: new Customer(
                email: 'johdoe@vivawallet.com',
                fullName: 'John Doe',
                phone: '+30999999999',
                countryCode: 'GB',
                requestLang: 'en-GB',
            ),
            sourceCode: strval(env('VIVA_SOURCE_CODE')),
            merchantTrns: 'Test merchant description',
        ));

        $this->assertIsNumeric($orderCode);
    }
}
