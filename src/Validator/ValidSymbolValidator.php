<?php

namespace App\Validator;

use App\DTO\API\NasdaqListingDTO;
use App\Service\NasdaqListingService;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class ValidSymbolValidator extends ConstraintValidator
{

    public function __construct(public NasdaqListingService $nasdaqListingService)
    {
    }

    public function validate($value, Constraint $constraint)
    {
        if (!$constraint instanceof ValidSymbol) {
            throw new UnexpectedTypeException($constraint, ValidSymbol::class);
        }

        if (is_null($value)) {
            return;
        }

        if (!$this->nasdaqListingService->findDataBySymbol($value) instanceof NasdaqListingDTO) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ string }}', $value)
                ->addViolation();
        }
    }
}