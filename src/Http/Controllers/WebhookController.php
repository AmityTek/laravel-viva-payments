<?php

namespace AmityTek\VivaPayments\Http\Controllers;

use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use AmityTek\VivaPayments\Events\TransactionFailed;
use AmityTek\VivaPayments\Events\TransactionPaymentCreated;
use AmityTek\VivaPayments\Events\WebhookEvent;
use AmityTek\VivaPayments\Services\Webhook;
use AmityTek\VivaPayments\VivaException;

class WebhookController extends Controller
{
    /**
     * Verify a webhook.
     *
     * @see https://developer.vivawallet.com/webhooks-for-payments/#generate-a-webhook-verification-key
     *
     * @throws GuzzleException
     * @throws VivaException
     */
    public function verify(Webhook $webhook): JsonReponse
    {
        return response()->json($webhook->getVerificationKey());
    }

    /**
     * Handle requests from Viva Wallet.
     *
     * @see https://developer.vivawallet.com/webhooks-for-payments/#handle-requests-from-viva-wallet
     */
    public function handle(Request $request): JsonResponse
    {
        /** @phpstan-ignore-next-line */
        $event = WebhookEvent::create($request->json()->all());

        event($event);

        match ($event->EventData::class) {
            TransactionPaymentCreated::class => event($event->EventData),
            TransactionFailed::class => event($event->EventData),
            default => null,
        };

        return response()->json();
    }
}
