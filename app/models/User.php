<?php

namespace App\Models;

use Core\Model;

class User extends Model
{
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

}