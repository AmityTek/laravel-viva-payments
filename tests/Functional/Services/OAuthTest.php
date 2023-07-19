<?php

namespace AmityTek\VivaPayments\Test\Functional\Services;

use GuzzleHttp\Exception\GuzzleException;
use AmityTek\VivaPayments\Facades\Viva;
use AmityTek\VivaPayments\Test\TestCase;
use AmityTek\VivaPayments\VivaException;

/** @covers \AmityTek\VivaPayments\Services\OAuth */
class OAuthTest extends TestCase
{
    /**
     * @test
     * @group functional
     * @doesNotPerformAssertions
     * @covers \AmityTek\VivaPayments\Responses\AccessToken
     *
     * @throws GuzzleException
     * @throws VivaException
     */
    public function it_requests_an_access_token_with_the_default_credentials(): void
    {
        Viva::oauth()->requestToken();
    }

    /**
     * @test
     * @group functional
     * @doesNotPerformAssertions
     * @covers \AmityTek\VivaPayments\Responses\AccessToken
     *
     * @throws GuzzleException
     * @throws VivaException
     */
    public function it_requests_an_access_token_with_the_given_credentials(): void
    {
        Viva::oauth()->requestToken(
            clientId: strval(env('VIVA_CLIENT_ID')),
            clientSecret: strval(env('VIVA_CLIENT_SECRET')),
        );
    }
}
