<?php

namespace Core\Validators;

use Core\Validators\Validator;

class MatchValidator extends Validator
{
    public function runValidation()
    {
        $value = $this->_object->{$this->field};

        return $value == $this->rule;
    }
}