<?php

namespace App\Models;

use Core\Model;
use Core\Validators\{RequiredValidator, UniqueValidator};

class Category extends Model
{
    protected static $table = 'categories';
    public $id;
    public $name;

    public function beforeSave()
    {
        $this->runValidation(new RequiredValidator($this, ['field' => 'name', 'message' => 'Name is required.']));
        $this->runValidation(new UniqueValidator($this, ['field' => 'name', 'message' => 'Category name already exists.']));
    }
}