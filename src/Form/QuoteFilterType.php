<?php

namespace App\Form;

use App\Entity\QuoteFilter;
use App\Service\NasdaqListingService;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class QuoteFilterType extends AbstractType
{

    public function __construct(
        public NasdaqListingService $nasdaqListingService
    )
    {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add( 'companySymbol',
                ChoiceType::class,
                [
                    'label'   => 'Company Symbol',
                    'choices' => $this->getCompanySymbols()
                ]
            )
            ->add('startDate', DateType::class, [
                'widget' => 'single_text'
            ])
            ->add('endDate', DateType::class, [
                'widget' => 'single_text'
            ])
            ->add('email', EmailType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => QuoteFilter::class,
        ]);
    }

    private function getCompanySymbols()
    {
        $listings = $this->nasdaqListingService->fetchListings();

        $results = [];
        foreach ($listings as $listing) {
             $results[$listing->getSymbol()] = $listing->getSymbol();
        }

        return $results;
    }
}
