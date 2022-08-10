<?php

namespace Core\Validators;

use Core\Validators\Validator;

class UniqueValidator extends Validator
{
    public function runValidation()
    {
        $value = $this->_object->{$this->field};
        
        if(! isset($value) || $value == '') {
            return true;
        }

        $conditions = "{$this->field} = :{$this->field}";
        $bind = [$this->field => $value];

        // if is updating
        if(! $this->_object->isNew()) {
            $conditions .= " AND id != :id";
            $bind['id'] = $this->_object->id;
        }

        // multiple unique validation
        foreach($this->additionalFeildData as $additionals) {
            $conditions .= " AND {$additionals} = :{$additionals}";
            $bind[$additionals] = $this->_object->{$additionals};
        }

        $queryParams = ['conditions' => $conditions, 'bind' => $bind];
        $isExisted = $this->_object::findFirst($queryParams);

        return ! $isExisted;
    }
}
