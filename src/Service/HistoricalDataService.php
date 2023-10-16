<?php

namespace App\Service;

use App\Entity\QuoteFilter;
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

    public function fetchData(QuoteFilter $quoteFilter)
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
                    'symbol' => $quoteFilter->getCompanySymbol()
                ]
            ]
        );

        //TODO filter and keep only the data between the input dates
        return $response->toArray();
    }
}