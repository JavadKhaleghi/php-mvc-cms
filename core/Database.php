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

            if($this->_fetchType === PDO::FETCH_CLASS) {
                $this->_results = $this->_statement->fetchAll($this->_fetchType, $this->_class);
            } else {
                $this->_results = $this->_statement->fetchAll($this->_fetchType);
            }
        } 

        return $this;
    }

    public function insert($table, $values)
    {
        $tableFields = [];
        $queryBinds = [];
        foreach($values as $key => $value) {
            $tableFields[] = $key;
            $queryBinds[] = ":{$key}";
        }

        $fieldString = implode('`, `', $tableFields);
        $bindString = implode(', ', $queryBinds);
        $sqlQuery = "INSERT INTO {$table} (`{$fieldString}`) VALUES ({$bindString});";

        $this->execute($sqlQuery, $values);

        return ! $this->_error;
    }

    public function update($table, $values, $conditions)
    {
        $queryBinds = [];
        $valueString = '';
        foreach($values as $field => $value) {
            $valueString .= ", `{$field}` = :{$field}";
            $queryBinds[$field] = $value;
        }

        $valueString = ltrim($valueString, ', ');
        $sqlQuery = "UPDATE {$table} SET {$valueString}";
        if(! empty($conditions)) {
            $conditionString = " WHERE ";
            foreach($conditions as $field => $value) {
                $conditionString .= "`{$field}` = :cond{$field}";
                $queryBinds['cond' . $field] = $value;
            }

            $conditionString = rtrim($conditionString, ' AND ');
            $sqlQuery .= $conditionString;
        }

        $this->execute($sqlQuery, $queryBinds);

        return ! $this->_error;
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

    public function setClass($className)
    {
        $this->_class = $className;
    }

    public function getClass()
    {
        return $this->_class;
    }

    public function setFetchType($fetchType)
    {
        $this->_fetchType = $fetchType;
    }
}