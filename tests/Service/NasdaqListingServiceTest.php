<?php

namespace App\Tests\Service;

use App\DTO\API\NasdaqListingDTO;
use App\Service\NasdaqListingService;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class NasdaqListingServiceTest extends KernelTestCase
{
    public function testFetchListings(): void
    {
        self::bootKernel();
        $container = static::getContainer();

        /** @var NasdaqListingService $listingService */
        $listingService = $container->get( NasdaqListingService::class);
        $listing = $listingService->fetchListings();
        $this->assertInstanceOf(\Generator::class, $listing);

        foreach ($listing as $item) {
            $this->assertNotEmpty($item->getCompanyName());
        }
    }

    public function testFindDataBySymbol()
    {
        self::bootKernel();
        $container = static::getContainer();

        /** @var NasdaqListingService $listingService */
        $listingService = $container->get( NasdaqListingService::class);
        $listing = $listingService->findDataBySymbol('AMRN');

        $this->assertInstanceOf(NasdaqListingDTO::class, $listing);
        $this->assertEquals('Amarin Corporation plc', $listing->getCompanyName());
        $this->assertEquals('AMRN', $listing->getSymbol());
    }
}