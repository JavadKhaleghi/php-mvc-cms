<?php

namespace App\Models;

use Core\{Model, Session, Cookie, Config};
use Core\Validators\{RequiredValidator, EmailValidator, MatchValidator, MinValidator, UniqueValidator};
use App\Models\UserSession;

class User extends Model
{
    const USER_PERMISSION = 'user';
    const AUTHOR_PERMISSION = 'author';
    const ADMIN_PERMISSION = 'admin';

    protected static $table = 'users';
    protected static $_current_user = false;
    public $id;
    public $first_name;
    public $last_name;
    public $email;
    public $password;
    public $acl;
    public $banned = 0;
    public $created_at;
    public $updated_at;
    public $confirm;
    public $remember = '';

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

    public function validateLogin()
    {
        $this->runValidation(new RequiredValidator($this, ['field' => 'email', 'message' => 'Email is required.']));
        $this->runValidation(new RequiredValidator($this, ['field' => 'password', 'message' => 'Password is required.']));
    }

    public function login($remember = false)
    {
        Session::set('logged_in_user', $this->id);
        self::$_current_user = $this;

        if($remember) {
            $currentTime = time();
            $newHashString = md5("{$this->id}_{$currentTime}");
            $session = UserSession::findByUserId($this->id);

            if(! $session) {
                $session = new UserSession();
            }

            $session->user_id = $this->id;
            $session->hash = $newHashString;
            $session->save();

            Cookie::set(Config::get('login_cookie_name'), $newHashString, 60 * 60 * 24 * 30); // 30 days in seconds

        }
    }

    public static function loginUserFromCookie()
    {
        $cookieName = Config::get('login_cookie_name');

        if(! Cookie::exists($cookieName)) {
            return false;
        }

        $hash = Cookie::get($cookieName);
        $session = UserSession::findByHashString($hash);

        if(! $session) {
            return false;
        }

        $currentUser = self::findById($session->user_id);

        if($currentUser) {
            $currentUser->login(true);
        }
    }

    public static function getCurrentLoggedInUser()
    {
        if(! self::$_current_user && Session::exists('logged_in_user')) {
            $userId = Session::get('logged_in_user');
            self::$_current_user = self::findById($userId);
        }

        if(! self::$_current_user) {
            self::loginUserFromCookie();
        }

        return self::$_current_user;
    }

    public function logout()
    {
        Session::delete('logged_in_user');
        self::$_current_user = false;
        $userSession = UserSession::findByUserId($this->id);

        if($userSession) {
            $userSession->delete();
        }

        Cookie::delete(Config::get('login_cookie_name'));
    }
}