<?php

namespace AmityTek\VivaPayments\Test\Unit\Services;

use GuzzleHttp\Exception\GuzzleException;
use AmityTek\VivaPayments\Test\TestCase;
use AmityTek\VivaPayments\VivaException;

/**
 * @covers \AmityTek\VivaPayments\Client
 * @covers \AmityTek\VivaPayments\Services\Webhook
 */
class WebhookTest extends TestCase
{
    /**
     * @test
     * @group unit
     * @covers \AmityTek\VivaPayments\Responses\WebhookVerificationKey
     *
     * @throws GuzzleException
     * @throws VivaException
     */
    public function it_gets_an_authorization_code(): void
    {
        $this->mockJsonResponses(['Key' => 'foo']);
        $this->mockRequests();

        $verification = $this->client->webhooks()->getVerificationKey();
        $request = $this->getLastRequest();

        $this->assertMethod('GET', $request);
        $this->assertEquals('foo', $verification->Key);
    }
}
