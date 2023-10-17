<?php

namespace App\Service;

use App\DTO\API\NasdaqListingDTO;
use Symfony\Component\Cache\Adapter\AdapterInterface;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Contracts\Cache\ItemInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class NasdaqListingService
{
    public function __construct(private HttpClientInterface $client,
        private string $nasdaqListingsURL,
        private AdapterInterface $cache
    ) {}

    public function fetchListings(): \Generator
    {
        $data = $this->fetchData();

        foreach ($data as $item) {
            yield new NasdaqListingDTO(
                companyName: $item['Company Name'],
                financialStatus: $item['Financial Status'],
                marketCategory: $item['Market Category'],
                roundLotSize: $item['Round Lot Size'],
                securityName: $item['Security Name'],
                symbol: $item['Symbol'],
                testIssue: $item['Test Issue']
            );
        }
    }

    public function findDataBySymbol(string $symbol): ?NasdaqListingDTO
    {
        $data = $this->fetchData();
        foreach ($data as $item) {
            if ($item['Symbol'] == $symbol) {
                return new NasdaqListingDTO(
                    companyName: $item['Company Name'],
                    financialStatus: $item['Financial Status'],
                    marketCategory: $item['Market Category'],
                    roundLotSize: $item['Round Lot Size'],
                    securityName: $item['Security Name'],
                    symbol: $item['Symbol'],
                    testIssue: $item['Test Issue']
                );
            }
        }

        return null;
    }

    private function fetchData(): array
    {
        return $this->cache->get('listings', function (ItemInterface $item): array {
            $item->expiresAfter(300);
            $response = $this->client->request(
                'GET',
                $this->nasdaqListingsURL
            );
            return $response->toArray();
        });
    }
}