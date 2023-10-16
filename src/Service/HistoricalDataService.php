<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class HistoricalDataService
{
    public function __construct(
        private HttpClientInterface $client,
        private string $historicalDataAPI,
        private string $XRapidAPIKey,
        private string $XRapidAPIHost
    ) {
    }

    public function fetchData(string $companySymbol)
    {
        $response = $this->client->request(
            'GET',
            $this->historicalDataAPI,
            [
                'headers' => [
                    'X-RapidAPI-Key' => $this->XRapidAPIKey,
                    'X-RapidAPI-Host' => $this->XRapidAPIHost,
                ],
                'query' => [
                    'symbol' => $companySymbol
                ]
            ]
        );

        return $response->toArray();
    }
}