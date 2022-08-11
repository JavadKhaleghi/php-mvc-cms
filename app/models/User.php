<?php

namespace App\Models;

use Core\Model;
use Core\Validators\{RequiredValidator, EmailValidator, MatchValidator, MinValidator, UniqueValidator};

class User extends Model
{
    const USER_PERMISSION = 'user';
    const AUTHOR_PERMISSION = 'author';
    const ADMIN_PERMISSION = 'admin';

    protected static $table = 'users';
    public $id;
    public $first_name;
    public $last_name;
    public $email;
    public $password;
    public $acl;
    public $banned = 0;
    public $created_at;
    public $updated_at;

    public function beforeSave()
    {
        $this->timeStamps();

        // run validation
        $this->runValidation(new RequiredValidator($this, ['field' => 'first_name', 'message' => 'First name is required.']));
        $this->runValidation(new RequiredValidator($this, ['field' => 'last_name', 'message' => 'Last name is required.']));
        $this->runValidation(new RequiredValidator($this, ['field' => 'email', 'message' => 'Email is required.']));
        $this->runValidation(new EmailValidator($this, ['field' => 'email', 'message' => 'Email is not valid.']));
        $this->runValidation(new UniqueValidator($this, ['field' => 'email', 'message' => 'Email has taken before.']));
        $this->runValidation(new RequiredValidator($this, ['field' => 'acl', 'message' => 'User\'s level is required.']));

        if($this->isNew() || $this->resetPassword) {
            $this->runValidation(new RequiredValidator($this, ['field' => 'password', 'message' => 'Password is required.']));
            $this->runValidation(new MinValidator($this, ['field' => 'password', 'rule' => 8, 'message' => 'Password must be at least 8 characters.']));
            //$this->runValidation(new MaxValidator($this, ['field' => 'password', 'rule' => 256, 'message' => 'Password must be a maximum of 256 charcters.']));
            $this->runValidation(new RequiredValidator($this, ['field' => 'confirm', 'message' => 'Confirm password is required.']));
            $this->runValidation(new MatchValidator($this, ['field' => 'confirm', 'rule' => $this->password, 'message' => 'Password and confirm must be same.']));

            $this->password = password_hash($this->password, PASSWORD_DEFAULT);
        } else {
            $this->_skipUpdate = ['password'];
        }
    }

}