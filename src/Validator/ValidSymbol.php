<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

#[\Attribute]
class ValidSymbol extends Constraint
{
    public string $message = 'The symbol "{{ string }}" is not valid. It was not found in the list of available symbols.';
}