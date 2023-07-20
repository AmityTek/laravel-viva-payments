<?php

namespace AmityTek\VivaPayments\Services;

use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\RequestOptions;
use AmityTek\VivaPayments\Client;
use AmityTek\VivaPayments\Requests;
use AmityTek\VivaPayments\Responses;
use AmityTek\VivaPayments\VivaException;

class Transaction
{
    public function __construct(protected Client $client)
    {
    }

    /**
     * Retrieve transaction.
     *
     * @see https://developer.vivawallet.com/apis-for-payments/payment-api/#tag/Transactions/paths/~1checkout~1v2~1transactions~1{transactionId}/get
     *
     * @param  array<string,mixed>  $guzzleOptions  Additional parameters for the Guzzle client
     *
     * @throws GuzzleException
     * @throws VivaException
     */
    public function retrieve(string $transactionId, array $guzzleOptions = []): Responses\Transaction
    {
        /** @phpstan-var TransactionArray */
        $response = $this->client->get(
            $this->client->getApiUrl()->withPath("/checkout/v2/transactions/{$transactionId}"),
            array_merge_recursive(
                $this->client->authenticateWithBearerToken(),
                $guzzleOptions,
            )
        );

        return Responses\Transaction::create($response);
    }

    /**
     * Create a recurring transaction.
     *
     * @see https://developer.vivawallet.com/apis-for-payments/payment-api/#tag/Transactions-(Deprecated)/paths/~1api~1transactions~1{transaction_id}/post
     *
     * @param  array<string,mixed>  $guzzleOptions  Additional parameters for the Guzzle client
     *
     * @throws GuzzleException
     * @throws VivaException
     */
    public function createRecurring(
        string $transactionId,
        Requests\CreateRecurringTransaction $transaction,
        array $guzzleOptions = []
    ): Responses\RecurringTransaction {
        /** @phpstan-var RecurringTransactionArray */
        $response = $this->client->post(
            $this->client->getUrl()->withPath("/api/transactions/{$transactionId}"),
            array_merge_recursive(
                [RequestOptions::JSON => $transaction],
                $this->client->authenticateWithBasicAuth(),
                $guzzleOptions
            )
        );

        return Responses\RecurringTransaction::create($response);
    }


    /**
     * Retrieve transaction.
     *
     * @see https://developer.vivawallet.com/apis-for-payments/payment-api/#tag/Transactions/paths/~1checkout~1v2~1transactions~1{transactionId}/get
     *
     * @param  array<string,mixed>  $guzzleOptions  Additional parameters for the Guzzle client
     *
     * @throws GuzzleException
     * @throws VivaException
     */
    public function retrieveAll($param, array $guzzleOptions = []): Responses\Transaction
    {
        /** @phpstan-var TransactionArray */
        $response = $this->client->get(
            $this->client->getApiUrl()->withPath("/checkout/v2/transactions/"),
            array_merge_recursive(
                $this->client->authenticateWithBearerToken(),
                $guzzleOptions,
            )
        );

        return Responses\Transaction::create($response);
    }

    public function listSubscriptions(array $guzzleOptions = [])
    {
        /** @phpstan-var TransactionArray */
        $response = $this->client->get(
            $this->client->getApiUrl()->withPath("/dataservices/v1/webhooks/subscriptions/"),
            array_merge_recursive(
                $this->client->authenticateWithBearerToken(),
                $guzzleOptions,
            )
        );

        return $response;
    }
}
