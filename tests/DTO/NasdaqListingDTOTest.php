<?php

namespace App\Tests\DTO;

use App\DTO\API\NasdaqListingDTO;
use PHPUnit\Framework\TestCase;

class NasdaqListingDTOTest extends TestCase
{

    public const COMPANY_NAME = 'Company Name',
        FINANCIAL_STATUS = 'Financial Status',
        MARKET_CATEGORY = 'Market Category',
        ROUND_LOT_SIZE = 100.2,
        SECURITY_NAME = 'Security Name',
        SYMBOL = 'Symbol',
        TEST_ISSUE = 'Test Issue';
    public function testDTO()
    {
        $dto = new NasdaqListingDTO(
            companyName: self::COMPANY_NAME,
            financialStatus: self::FINANCIAL_STATUS,
            marketCategory: self::MARKET_CATEGORY,
            roundLotSize: self::ROUND_LOT_SIZE,
            securityName: self::SECURITY_NAME,
            symbol: self::SYMBOL,
            testIssue: self::TEST_ISSUE
        );

        $this->assertEquals(self::COMPANY_NAME, $dto->getCompanyName());
        $this->assertEquals(self::FINANCIAL_STATUS, $dto->getFinancialStatus());
        $this->assertEquals(self::MARKET_CATEGORY, $dto->getMarketCategory());
        $this->assertEquals(self::ROUND_LOT_SIZE, $dto->getRoundLotSize());
        $this->assertEquals(self::SECURITY_NAME, $dto->getSecurityName());
        $this->assertEquals(self::SYMBOL, $dto->getSymbol());
        $this->assertEquals(self::TEST_ISSUE, $dto->getTestIssue());
    }
}