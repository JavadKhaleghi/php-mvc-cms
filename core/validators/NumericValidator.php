<?php

namespace Core\Validators;

use Core\Validators\Validator;

class NumericValidator extends Validator
{
    public function runValidation()
    {
        $value = $this->_object->{$this->field};
        $passedValidation = true;

        if(! empty($value)) {
            $passedValidation = is_numeric($value);
        }

        return $passedValidation;
    }
}
