<?php

namespace App\Controller;

use App\Entity\QuoteFilter;
use App\Form\QuoteFilterType;
use App\Service\HistoricalDataService;
use App\Service\NasdaqListingService;
use App\Service\NotificationService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class QuoteController extends AbstractController
{

    #[Route('/', methods: ['GET', 'POST'])]
    public function index(
        Request $request,
        HistoricalDataService $historicalDataService,
        NotificationService $notificationService)
    {
        $quoteFilter = new QuoteFilter();

        $form = $this->createForm(QuoteFilterType::class, $quoteFilter);

        $form->handleRequest($request);
        $historicalData = [];
        $errorMessage = null;

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var QuoteFilter $quoteFilter */
            $quoteFilter = $form->getData();

            try {
                $historicalData = $historicalDataService->fetchData($quoteFilter);
                $sentMessage = $notificationService->sendEmail($quoteFilter);
                //easy way to debug the email
                //dd($sentMessage);
            } catch (\Throwable $throwable) {
//                dd($throwable);
                $errorMessage = 'No data found for '.$quoteFilter->getCompanySymbol();
            }
        }

        return $this->render('quote/index.html.twig', [
            'form' => $form->createView(),
            'historicalData' => $historicalData,
            'errorMessage' => $errorMessage
        ]);
    }
}