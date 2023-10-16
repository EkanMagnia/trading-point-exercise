<?php

namespace App\DTO\API;

class NasdaqListingDTO
{
    public function __construct(
        public string $companyName,
        public ?string $financialStatus = null,
        public ?string $marketCategory = null,
        public ?float $roundLotSize = null,
        public ?string $securityName = null,
        public ?string $symbol = null,
        public ?string $testIssue = null
    ) {}

    public function getCompanyName(): ?string
    {
        return $this->companyName;
    }

    public function getFinancialStatus(): ?string
    {
        return $this->financialStatus;
    }

    public function getMarketCategory(): ?string
    {
        return $this->marketCategory;
    }

    public function getRoundLotSize(): ?float
    {
        return $this->roundLotSize;
    }

    public function getSecurityName(): ?string
    {
        return $this->securityName;
    }

    public function getSymbol(): ?string
    {
        return $this->symbol;
    }

    public function getTestIssue(): ?string
    {
        return $this->testIssue;
    }
}