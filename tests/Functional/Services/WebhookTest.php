<?php

namespace AmityTek\VivaPayments\Test\Functional\Services;

use GuzzleHttp\Exception\GuzzleException;
use AmityTek\VivaPayments\Facades\Viva;
use AmityTek\VivaPayments\Test\TestCase;
use AmityTek\VivaPayments\VivaException;

/** @covers \AmityTek\VivaPayments\Services\Webhook */
class WebhookTest extends TestCase
{
    /**
     * @test
     * @group functional
     *
     * @throws GuzzleException
     * @throws VivaException
     */
    public function it_gets_a_verification_key(): void
    {
        $verification = Viva::webhooks()->getVerificationKey();

        $this->assertNotEmpty($verification->Key, "Failed asserting that '{$verification->Key}' is not empty.");
    }
}
