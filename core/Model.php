<?php

namespace Core;

use PDO;
use Core\Database;
use Core\Request;

class Model
{
    protected static $table = '';
    protected static $columns = false;
    protected $_validationPassed = true;
    protected $_errors = [];
    protected $_skipUpdate = [];

    protected static function getDatabase($setFetchClass = false)
    {
        $db = Database::getInstance();
        if($setFetchClass) {
            $db->setClass(get_called_class());
            $db->setFetchType(PDO::FETCH_CLASS);
        }

        return $db;
    }

    public static function insert($values)
    {
        $db = static::getDatabase();

        return $db->insert(static::$table, $values);
    }

    public static function update($values, $conditions)
    {
        $db = static::getDatabase();

        return $db->update(static::$table, $values, $conditions);
    }

    public function delete()
    {
        $db = static::getDatabase();
        $table = static::$table;
        $params = [
            'conditions' => "id = :id",
            'bind' => ['id' => $this->id]
        ];

        list('sql' => $conditions, 'bind' => $bind) = self::queryParamBiulder($params);
        $sqlQuery = "DELETE FROM {$table} {$conditions}";

        return $db->execute($sqlQuery, $bind);
    }

    public static function find($params = [])
    {
        $db = static::getDatabase(true);
        list('sql' => $sqlQuery, 'bind' => $bind) = self::selectBuilder($params);

        return $db->query($sqlQuery, $bind)->results();
    }

    public static function findFirst($params = [])
    {
        $db = static::getDatabase(true);
        list('sql' => $sqlQuery, 'bind' => $bind) = self::selectBuilder($params);
        $results = $db->query($sqlQuery, $bind)->results();

        return isset($results[0]) ? $results[0] : false;
    }

    public static function findById($id)
    {
        return self::findFirst([
            'conditions' => "id = :id",
            'bind' => ['id' => $id]
        ]);
    }

    public static function findTotal($params = [])
    {
        unset($params['limit']);
        unset($params['offset']);
        
        $table = static::$table;
        $sqlQuery = "SELECT COUNT(*) AS total FROM {$table}";
        list('sql' => $conditions, 'bind' => $bind) = self::queryParamBiulder($params);
        $sqlQuery .= $conditions;
        $db = static::getDatabase();
        $results = $db->query($sqlQuery, $bind);
        $total = $results->getRowCount() > 0 ? $results->results()[0]->total : 0;

        return $total;
    }

    public function save()
    {
        $save = false;
        $this->beforeSave();
        if($this->_validationPassed) {
            $db = static::getDatabase();
            $values = $this->getValuesForSave();

            if($this->isNew()) {
                $save = $db->insert(static::$table, $values);
                if($save) {
                    $this->id = $db->getLastInsertId();
                }
            } else {
                $save = $db->update(static::$table, $values, ['id' => $this->id]);
            }
        }

        return $save;
    }

    public function isNew()
    {
        return empty($this->id);
    }

    public static function selectBuilder($params = [])
    {
        $columns = array_key_exists('columns', $params) ? $params['columns'] : '*';
        $table = static::$table;
        $sqlQuery = "SELECT {$columns} FROM {$table}";

        list('sql' => $conditions, 'bind' => $bind) = self::queryParamBiulder($params);

        $sqlQuery .= $conditions;

        return ['sql' => $sqlQuery, 'bind' => $bind];
    }

    public static function queryParamBiulder($params = [])
    {
        $sqlQuery = "";
        $bind = array_key_exists('bind', $params) ? $params['bind'] : [];

        // join query
        /*
            [
                ['table2', 'table1.id = table2.key', 'tableAlias', 'JOIN TYPE']
            ]
        */
        if (array_key_exists('joins', $params)) {
            $joins = $params['joins'];
            foreach($joins as $join) {
                $joinTable = $join[0];
                $joinOn = $join[1];
                $joinAlias = isset($join[2]) ? $join[2] : '';
                $joinType = isset($join[3]) ? "{$join[3]} JOIN" : "JOIN";

                $sqlQuery .= " {$joinType} {$joinTable} {$joinAlias} ON {$joinOn}";
            }
        }

        // where query
        if(array_key_exists('group', $params)) {
            $groupBy = $params['group'];
            $sqlQuery .= " GROUP BY {$groupBy}";
        }

        // group query
        if (array_key_exists('conditions', $params)) {
            $conditions = $params['conditions'];
            $sqlQuery .= " WHERE {$conditions}";
        }

        // order by query
        if (array_key_exists('order', $params)) {
            $orderBy = $params['order'];
            $sqlQuery .= " ORDER BY {$orderBy}";
        }

        // limit query
        if (array_key_exists('limit', $params)) {
            $limit = $params['limit'];
            $sqlQuery .= " LIMIT {$limit}";
        }

        // offset query
        if(array_key_exists('offset', $params)) {
            $offset = $params['offset'];
            $sqlQuery .= " OFFSET {$offset}";
        }

        return ['sql' => $sqlQuery, 'bind' => $bind];
    }

    public function getValuesForSave()
    {
        $columns = static::getColumns();
        $values = [];

        foreach($columns as $column) {
            if(! in_array($column, $this->_skipUpdate)) {
                $values[$column] = $this->{$column};
            }
        }

        return $values;
    }

    public static function getColumns()
    {
        if(! static::$columns) {
            $db = static::getDatabase();
            $table = static::$table;
            $sqlQuery = "SHOW COLUMNS FROM {$table}";
            $results = $db->query($sqlQuery)->results();
            $columns = [];

            foreach($results as $column) {
                $columns[] = $column->Field;
            }

            static::$columns = $columns;
        }

        return static::$columns;
    }

    public function runValidation($validator)
    {
        $isValidated = $validator->runValidation();
        if(! $isValidated) {
            $this->_validationPassed = false;
            $this->_errors[$validator->field] = $validator->msg;
        }
    }

    public function getErrors()
    {
        return $this->_errors;
    }

    public function setError($name, $value)
    {
        $this->_errors[$name] = $value;
    }

    public function timeStamps()
    {
        $dateTime = new \DateTime("now", new \DateTimeZone("Asia\Tehran"));
        $now = $dateTime->format('Y-m-d H:i:s');
        $this->updated_at = $now;

        if($this->isNew()) {
            $this->created_at = $now;
        }
    }

    public static function mergeWithPagination($params = [])
    {
        $request = new Request();
        $page = $request->get('page');
        if(! $page || $page < 1) {
            $page = 1;
        }

        $limit = $request->get('limit') ? $request->get('limit') : 15;
        $offset = ($page - 1) * $limit;
        $params['limit'] = $limit;
        $params['offset'] = $offset;

        return $params;
    }

    public function beforeSave()
    {
        
    }
}