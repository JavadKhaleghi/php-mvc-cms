<?php

namespace Core\Validators;

use Core\Validators\Validator;

class RequiredValidator extends Validator
{
    public function runValidation()
    {
        $value = trim($this->_object->{$this->field});
        
        return isset($value) && $value != '';
    }
}