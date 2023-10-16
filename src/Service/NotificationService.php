<?php

namespace App\Service;

use App\Entity\QuoteFilter;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\SentMessage;
use Symfony\Component\Mailer\Transport\TransportInterface;
use Symfony\Component\Mime\Email;

class NotificationService
{

    public function __construct(private TransportInterface $mailer, private NasdaqListingService $nasdaqListingService)
    {
    }

    /**
     * @throws TransportExceptionInterface
     */
    public function sendEmail(QuoteFilter $quoteFilter): SentMessage
    {
        $listing = $this->nasdaqListingService->findDataBySymbol($quoteFilter->getCompanySymbol());

        $email = (new Email())
            ->from('hello@example.com')
            ->to($quoteFilter->getEmail())
            ->subject($listing->getCompanyName())
            ->text('From ' . $quoteFilter->getStartDate()->format('Y-m-d') . ' to ' .
                $quoteFilter->getEndDate()->format('Y-m-d'));

        return $this->mailer->send($email);
    }
}