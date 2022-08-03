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
        if(! self::$_db) {
            self::$_db = new self();
        }

        return self::$_db;
    }

    /**
     * Execute a raw SQL query
     */
    public function execute($sql, $bind = [])
    {
        $this->_results = null;
        $this->_lastInsertId = null;
        $this->_error = false;

        $this->_statement = $this->_dbHandler->prepare($sql);
        if(!$this->_statement->execute($bind)) {
            $this->_error = true;
        } else {
            $this->_lastInsertId = $this->_dbHandler->lastInsertId();
        }

        return $this;
    }

    public function query($sql, $bind = [])
    {
        $this->execute($sql, $bind);
        if (! $this->_error) {
            $this->_rowCount = $this->_statement->rowCount();
            $this->_results = $this->_statement->fetchAll($this->_fetchType);
        } 

        return $this;
    }

    public function results()
    {
        return $this->_results;
    }

    public function count()
    {
        return $this->_rowCount;
    }

    public function lastInsertId()
    {
        return $this->_lastInsertId;
    }
}