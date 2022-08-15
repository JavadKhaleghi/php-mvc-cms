<?php

namespace App\Models;

use Core\Model;
use Core\Validators\RequiredValidator;

class Article extends Model
{
    protected static $table = 'articles';
    public $id;
    public $title;
    public $body;
    public $category_id = 0;
    public $status = 'private';
    public $user_id;
    public $cover_image;
    public $created_at;
    public $updated_at;

    public function beforeSave()
    {
        $this->timeStamps();
        $this->runValidation(new RequiredValidator($this, ['field' => 'title', 'message' => 'Title is required.']));
        $this->runValidation(new RequiredValidator($this, ['field' => 'body', 'message' => 'Body is required.']));
    }
}
