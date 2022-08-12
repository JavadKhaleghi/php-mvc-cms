<?php

namespace App\Models;

use Core\Model;

class UserSession extends Model
{
    protected static $table = 'user_sessions';
    public $id;
    public $user_id;
    public $hash;

    public static function findByUserId($userId)
    {
        return self::findFirst([
            'conditions' => "user_id = :user_id",
            'bind' => ['user_id' => $userId]
        ]);
    }

    public static function findByHashString($hash)
    {
        return self::findFirst([
            'conditions' => "hash = :hash",
            'bind' => ['hash' => $hash]
        ]);
    }
}