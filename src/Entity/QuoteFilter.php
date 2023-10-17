<?php

namespace App\Entity;

use App\Repository\QuoteFilterRepository;
use App\Validator\ValidSymbol;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=QuoteFilterRepository::class)
 */
class QuoteFilter
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    #[Assert\NotBlank]
    #[ValidSymbol]
    private string $companySymbol;

    /**
     * @ORM\Column(type="datetime", nullable=false)
     */
    #[Assert\NotBlank]
    #[Assert\Type(\DateTimeInterface::class)]
    #[Assert\LessThanOrEqual('today')]
    private \DateTimeInterface $startDate;

    /**
     * @ORM\Column(type="datetime", nullable=false)
     */
    #[Assert\NotBlank]
    #[Assert\Type(\DateTimeInterface::class)]
    #[Assert\LessThanOrEqual('today')]
    private ?\DateTimeInterface $endDate;

    /**
     * @ORM\Column(type="string", length=100)
     */
    #[Assert\NotBlank]
    #[Assert\Email]
    private string $email;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCompanySymbol(): ?string
    {
        return $this->companySymbol;
    }

    public function setCompanySymbol(string $companySymbol): self
    {
        $this->companySymbol = $companySymbol;

        return $this;
    }

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->startDate;
    }

    public function setStartDate(?\DateTimeInterface $startDate): self
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->endDate;
    }

    public function setEndDate(?\DateTimeInterface $endDate): self
    {
        $this->endDate = $endDate;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }
}
