<?php

namespace AmityTek\VivaPayments\Test\Unit;

use AmityTek\VivaPayments\Client;
use AmityTek\VivaPayments\Facades\Viva;
use AmityTek\VivaPayments\Test\TestCase;

/** @covers \AmityTek\VivaPayments\Facades\Viva */
class VivaTest extends TestCase
{
    /**
     * @test
     * @group unit
     */
    public function it_proxies_the_client(): void
    {
        $viva = Viva::getFacadeRoot();

        $this->assertInstanceOf(Client::class, $viva);
    }
}
