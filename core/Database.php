<?php

namespace Core;

use PDO;
use Exception;
use Core\{Config, Helper};

class Database
{
    protected $_dbHandler;
    protected $_results;
    protected $_lastInsertId;
    protected $_rowCount = 0;
    protected $_fetchType = PDO::FETCH_OBJ;
    protected $_class;
    protected $_error = false;
    protected $_statement;
    protected static $_db;

    public function __construct()
    {
        $host     = Config::get('db_host');
        $name     = Config::get('db_name');
        $user     = Config::get('db_user');
        $password = Config::get('db_password');

        $dbOptions = [
            PDO::ATTR_EMULATE_PREPARES   => false,
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
        ];

        try {
            $this->_dbHandler = new PDO("mysql:host={$host};dbname={$name};charset=utf8mb4", $user, $password, $dbOptions);
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage());
        }
    }

    /**
     * Make an instance of databse, if there wasn't any before
     */
    public static function getInstance()
    {
        if(!self::$_db) {
            self::$_db = new self();
        }

        return self::$_db;
    }
}