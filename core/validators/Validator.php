<?php

namespace Core\Validators;

abstract class Validator
{
    public $success = true;
    public $message = '';
    public $field;
    public $additionalFeildData = [];
    public $rule;
    public $includeDeleted = false;
    protected $_object;

    public function __construct($object, $params)
    {
        $this->_object = $object;
        
        if(! array_key_exists('field', $params)) {
            throw new \Exception("Add a field to parameters array.");
        }

        $this->field = $params['field'];
        
        if(is_array($params['field'])) {
            $this->field = $params['field'][0];
            array_shift($params['field']);
            $this->additionalFeildData = $params['field'];
        }

        if(! property_exists($this->_object, $this->field)) {
            throw new \Exception("The field must exists as a property on model object.");
        }

        if(! array_key_exists('message', $params)) {
            throw new \Exception("Add a message to parameter's array");
        }

        $this->message = $params['message'];

        if(array_key_exists('rule', $params)) {
            $this->rule = $params['rule'];
        }

        if(array_key_exists('includeDeleted', $params) && $params['includeDeleted']) {
            $this->includeDeleted = true;
        }

        try {
            $this->success = $this->runValidation();
        } catch(\Exception $error) {
            echo "Validation Exception on " . get_class() . ": " . $error->getMessage() . "<br>";
        }
    }

    abstract public function runValidation();
}