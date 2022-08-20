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
    
    public static function findAllWithArticles()
    {
        $params = [
            'columns' => 'categories.*',
            'joins' => [
                ['articles', 'articles.category_id = categories.id']
            ],
            'group' => 'categories.id',
            'order' => 'categories.name'
        ];
        
        return self::find($params);
    }
}