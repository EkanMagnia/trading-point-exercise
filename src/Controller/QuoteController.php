<?php

namespace App\Controller;

use App\Entity\QuoteFilter;
use App\Form\QuoteFilterType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class QuoteController extends AbstractController
{

    #[Route('/', methods: ['GET', 'POST'])]
    public function index(Request $request)
    {
        $quoteFilter = new QuoteFilter();

        $form = $this->createForm(QuoteFilterType::class, $quoteFilter);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $quoteFilter = $form->getData();
            dd($quoteFilter);
        }

        return $this->render('quote/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}