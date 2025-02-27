<?php

namespace AmityTek\VivaPayments\Test\Unit;

use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Event;
use AmityTek\VivaPayments\Events\TransactionFailed;
use AmityTek\VivaPayments\Events\TransactionPaymentCreated;
use AmityTek\VivaPayments\Events\WebhookEvent;
use AmityTek\VivaPayments\Http\Controllers\WebhookController;
use AmityTek\VivaPayments\Services\Webhook;
use AmityTek\VivaPayments\Test\TestCase;
use AmityTek\VivaPayments\VivaException;

/** @covers \AmityTek\VivaPayments\Http\Controllers\WebhookController */
class WebhookControllerTest extends TestCase
{
    /**
     * @test
     * @group unit
     *
     * @throws GuzzleException
     * @throws VivaException
     */
    public function it_verifies_a_webhook(): void
    {
        $this->mockJsonResponses(['Key' => 'foo']);

        $webhook = new Webhook($this->client);

        $controller = new WebhookController();

        $response = $controller->verify($webhook);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(['Key' => 'foo'], $response->getData(assoc: true));
    }

    /**
     * @test
     * @group unit
     * @covers \AmityTek\VivaPayments\Events\WebhookEvent
     */
    public function it_handles_a_notification_event(): void
    {
        Event::fake();

        $controller = new WebhookController();

        $event = strval(file_get_contents(__DIR__.'/../Stubs/transaction-price-calculated.json'));

        $request = Request::create('/', 'POST', content: $event);

        $response = $controller->handle($request);

        $this->assertEquals(200, $response->getStatusCode());

        Event::assertDispatched(WebhookEvent::class);
    }

    /**
     * @test
     * @group unit
     * @covers \AmityTek\VivaPayments\Events\TransactionPaymentCreated
     */
    public function it_handles_a_create_transaction_notification_event(): void
    {
        Event::fake();

        $controller = new WebhookController();

        $event = strval(file_get_contents(__DIR__.'/../Stubs/transaction-payment-created.json'));

        $request = Request::create('/', 'POST', content: $event);

        $response = $controller->handle($request);

        $this->assertEquals(200, $response->getStatusCode());

        Event::assertDispatched(WebhookEvent::class);
        Event::assertDispatched(TransactionPaymentCreated::class);
    }

    /**
     * @test
     * @group unit
     * @covers \AmityTek\VivaPayments\Events\TransactionFailed
     */
    public function it_handles_a_transaction_failed_notification_event(): void
    {
        Event::fake();

        $controller = new WebhookController();

        $event = strval(file_get_contents(__DIR__.'/../Stubs/transaction-failed.json'));

        $request = Request::create('/', 'POST', content: $event);

        $response = $controller->handle($request);

        $this->assertEquals(200, $response->getStatusCode());

        Event::assertDispatched(WebhookEvent::class);
        Event::assertDispatched(TransactionFailed::class);
    }
}
