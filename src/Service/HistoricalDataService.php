<?php

namespace App\Service;

use App\Entity\QuoteFilter;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class HistoricalDataService
{
    public function __construct(
        private HttpClientInterface $client,
        private string              $historicalDataAPI,
        private string              $XRapidAPIKey,
        private string              $XRapidAPIHost
    )
    {
    }

    public function fetchData(QuoteFilter $quoteFilter): array
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

        $apiData = $response->toArray();

        return $this->filterResults($apiData, $quoteFilter);
    }

    public function filterResults(array $apiData, QuoteFilter $quoteFilter): array
    {
        $startDate = $quoteFilter->getStartDate()->getTimestamp();
        $endDate = $quoteFilter->getEndDate()->getTimestamp();

        $results = [];
        foreach ($apiData['prices'] as $price) {
            if ($price['date'] >= $startDate && $price['date'] <= $endDate) {
                $results[] = $price;
            }
        }

        return $results;
    }
}