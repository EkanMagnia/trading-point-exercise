<?php

namespace App\Tests\Service;

use App\Entity\QuoteFilter;
use App\Service\HistoricalDataService;
use App\Service\NasdaqListingService;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class HistoricalDataServiceTest extends KernelTestCase
{

    public function testFetchListings(): void
    {
        self::bootKernel();
        $container = static::getContainer();

        /** @var HistoricalDataService $listingService */
        $historicalDataService = $container->get( HistoricalDataService::class);

        $quoteFilter = new QuoteFilter();
        $quoteFilter->setCompanySymbol('AMRN')
            ->setEmail('test@test.com')
            ->setStartDate(new \DateTime('2023-10-12'))
            ->setEndDate(new \DateTime('2023-10-14'));

        $data = $historicalDataService->fetchData($quoteFilter);

        $this->assertIsArray($data);
        $first = reset($data);
        $this->assertIsInt($first['date']);
        $this->assertArrayHasKey('open', $first);
        $this->assertArrayHasKey('high', $first);
        $this->assertArrayHasKey('low', $first);
    }
}