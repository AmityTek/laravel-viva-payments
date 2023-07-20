<?php

namespace AmityTek\VivaPayments\Services;

use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\RequestOptions;
use AmityTek\VivaPayments\Client;
use AmityTek\VivaPayments\Requests;
use AmityTek\VivaPayments\Responses;
use AmityTek\VivaPayments\VivaException;

class Api
{
    public function __construct(protected Client $client)
    {
    }

    public function callBearerToken($url, array $guzzleOptions = [])
    {
        /** @phpstan-var TransactionArray */
        $response = $this->client->get(
            $url,
            array_merge_recursive(
                $this->client->authenticateWithBearerToken(),
                $guzzleOptions,
            )
        );

        return $response;
    }


    public function callBasicAuth($url, array $guzzleOptions = [])
    {
        /** @phpstan-var TransactionArray */
        $response = $this->client->get(
            $url,
            array_merge_recursive(
                $this->client->authenticateWithBasicAuth(),
                $guzzleOptions,
            )
        );

        return $response;
    }
}
