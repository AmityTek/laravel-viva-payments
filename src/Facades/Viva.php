<?php

namespace AmityTek\VivaPayments\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \AmityTek\VivaPayments\Services\Card cards()
 * @method static \AmityTek\VivaPayments\Services\Order orders()
 * @method static \AmityTek\VivaPayments\Services\Transaction transactions()
 * @method static \AmityTek\VivaPayments\Services\Webhook webhooks()
 * @method static \AmityTek\VivaPayments\Services\ISV isv()
 * @method static \AmityTek\VivaPayments\Client withEnvironment(\AmityTek\VivaPayments\Enums\Environment|string $environment)
 * @method static \AmityTek\VivaPayments\Client withBasicAuthCredentials(string $merchantId, string $apiKey)
 * @method static \AmityTek\VivaPayments\Client withOAuthCredentials(string $clientId, string $clientSecret)
 * @method static \AmityTek\VivaPayments\Client withToken(string $token)
 *
 * @see \AmityTek\VivaPayments\Client
 */
class Viva extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return \AmityTek\VivaPayments\Client::class;
    }
}
