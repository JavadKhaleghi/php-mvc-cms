<?php

namespace Core\Validators;

use Core\Validators\Validator;

class EmailValidator extends Validator
{
    public function runValidation()
    {
        $email = $this->_object->{$this->field};
        $passedValidation = true;

        if(! empty($email)) {
            $passedValidation = filter_var($email, FILTER_VALIDATE_EMAIL);
        }

        return $passedValidation;
    }
}