<?php

namespace AmityTek\VivaPayments\Responses;

class WebhookVerificationKey
{
    public function __construct(public readonly string $Key)
    {
    }
}
