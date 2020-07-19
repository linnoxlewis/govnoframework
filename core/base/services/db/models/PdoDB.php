<?php

namespace core\base\services\db\models;

use core\base\abstracts\DbInterface;
use core\Config;
use PDO;

/**
 * Class PDO DB
 *
 * @package core\base\db
 */
class PdoDB implements DbInterface
{
    /**
     * Config class
     *
     * @var string
     */
    protected static $configClass = Config::class;

    /**
     * Class db
     *
     * @var object
     */
    protected static $dbClass;

    /**
     * Query
     *
     * @var string
     */
    protected $query = '';

    /**
     * Params for prepare query
     *
     * @var array
     */
    protected $params = [];


    /**
     * Connection to database and return it
     *
     * @param string $host
     * @param int $port
     * @param string $user
     * @param string $password
     * @param string $type
     * @param string $database
     * @param array $options
     *
     * @return $this
     * @throws \Exception
     */
    public function connection(string $host, int $port, string $user, string $password, string $type, string $database, $options = [])
    {
        $config = $type . ':' . 'host=' . $host
            . ';port=' . $port
            . ';dbname=' . $database
            . ';user=' . $user
            . ';password=' . $password
            . ';charset=utf8';
        $opt = (!empty($options))
            ? $options
            : static::getDefaultOptions();
        try {
            static::$dbClass = new PDO($config, $user, $password, $opt);
            return $this;
        } catch (\PDOException $e) {
            throw new \Exception('Failed connection DB.' . $e->getMessage());
        }
    }

    /**
     * Get query params
     *
     * @return array
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
     * Get connection params
     *
     * @return string
     * @throws \Exception
     */
    protected static function getDBConnectionParams(): string
    {
        try {
            $config = static::$configClass;
            $config = $config::getDbParams();
            if (!is_array($config) || !isset($config['host'])
                || !isset($config['type'])
                || !isset($config['database'])
                || !isset($config['user'])
                || !isset($config['password'])
                || !isset($config['port'])
            ) {
                throw new \Exception('Invalid config Params', 401);
            }
            if (!in_array($config['type'], static::getDbList())) {
                throw new \Exception('Invalid database type', 401);
            }
            $charset = (!isset($config['charset']))
                ? 'utf8'
                : $config['charset'];
            return $config['type'] . ':' . 'host=' . $config['host']
                . ';port=' . $config['port']
                . ';dbname=' . $config['database']
                . ';user=' . $config['user']
                . ';password=' . $config['password']
                . ';charset=' . $charset;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Get databases list
     *
     * @return array
     */
    protected static function getDbList(): array
    {
        return ['mysql', 'pgsql'];
    }

    /**
     * Get default pdo options
     *
     * @return array
     */
    protected static function getDefaultOptions(): array
    {
        return [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];
    }

    /**
     * Generate Select query
     *
     * @param null|string|array $fields table fields
     * @param bool $distinct is distinct request
     *
     * @return $this
     */
    public function select($fields = null, $distinct = false)
    {
        if (empty($fields)) {
            $fields = '*';
        }
        if (is_array($fields)) {
            $fields = implode(',', $fields);
        }
        $query = (!$distinct)
            ? 'SELECT '
            : 'SELECT DISTINCT ';
        $this->query = $query . $fields;
        return $this;
    }

    /**
     * Select min field
     *
     * @param string $field table field
     * @return $this
     */
    public function min(string $field)
    {
        $this->checkSelectExist();
        $this->query .= 'MIN(' . $field . ')';
        return $this;
    }

    /**
     * Select max field
     *
     * @param string $field table field
     *
     * @return $this
     */
    public function max(string $field)
    {
        $this->checkSelectExist();
        $this->query .= 'MAX(' . $field . ')';
        return $this;
    }

    /**
     * Select avg field
     *
     * @param string $field table field
     *
     * @return $this
     */
    public function avg(string $field)
    {
        $this->checkSelectExist();
        $this->query .= 'AVG(' . $field . ')';
        return $this;
    }

    /**
     * Select sum fields
     *
     * @param string $field table field
     *
     * @return $this
     */
    public function sum(string $field)
    {
        $this->checkSelectExist();
        $this->query .= 'SUM(' . $field . ')';
        return $this;
    }

    /**
     * Select count fields
     *
     * @param string|null $field table field
     *
     * @return $this
     */
    public function count(string $field = null)
    {
        if (empty($field)) {
            $field = '*';
        }
        $this->checkSelectExist();
        $this->query .= 'COUNT(' . $field . ')';
        return $this;
    }

    /**
     * Generate Insert query
     *
     * @param string $tableName table name
     * @param array $values insert values
     *
     * @return $this
     */
    public function insert(string $tableName, array $values)
    {
        $countValues = count($values);
        $count = 0;
        $resultConditions = '(';
        $keys = '(';
        foreach ($values as $key => $value) {
            $count++;
            $resultConditions .= '?';
            $keys .= $key;
            if ($count !== $countValues) {
                $resultConditions .= ',';
                $keys .= ',';
            } else {
                $resultConditions .= ')';
                $keys .= ')';
            }
            $this->params[] = $value;
        }
        $this->query = 'INSERT INTO ' . $tableName . ' ' . $keys . ' VALUES ' . $resultConditions;
        return $this;
    }

    /**
     * Generate Update query
     *
     * @param string $tableName table
     * @param array $fields table fields
     *
     * @return $this
     */
    public function update(string $tableName, array $fields)
    {
        $countValues = count($fields);
        $count = 0;
        $query = '';
        foreach ($fields as $key => $value) {
            $count++;
            $query .= $key . ' = ?';
            if ($count !== $countValues) {
                $query .= ',';
            }
            $this->params[] = $value;
        }
        $this->query = 'UPDATE ' . $tableName . ' SET ' . $query;
        return $this;
    }

    /**
     * Generate Delete query
     *
     * @param string $tableName table name
     *
     * @return $this
     */
    public function delete($tableName)
    {
        $this->query = 'DELETE FROM ' . $tableName;
        return $this;
    }

    /**
     * Execute query
     *
     * @return bool
     */
    public function execute()
    {
        $query = static::$dbClass->prepare($this->query);
        $result = $query->execute($this->params);
        unset($this->query);
        unset($this->params);
        unset($this->table);
        return $result;
    }

    /**
     * Generate FROM query
     *
     * @param string $tablename table
     *
     * @return $this
     */
    public function from(string $tablename)
    {
        $this->table = $tablename;
        $this->query = $this->query . ' FROM ' . $tablename;
        return $this;
    }

    /**
     * Get SQL string
     *
     * @return string
     */
    public function getRawSql()
    {
        return $this->query;
    }

    public function query($query)
    {
        $query = static::$dbClass->query($query);
        $result = [];
        while ($row = $query->fetch()) {
            $result[] = $row;
        }
        return $result;
    }

    /**
     * get one result query
     *
     * @return mixed
     */
    public function one()
    {
        $query = static::$dbClass->prepare($this->query);
        $query->execute($this->params);
        unset($this->query);
        unset($this->params);
        unset($this->table);
        return $query->fetch();
    }

    /**
     * get all result query
     *
     * @return mixed
     */
    public function all()
    {
        $query = static::$dbClass->prepare($this->query);
        $query->execute($this->params);
        unset($this->query);
        unset($this->params);
        unset($this->table);
        $result = [];
        while ($row = $query->fetch()) {
            $result[] = $row;
        }
        return $result;
    }

    /**
     * Generate WHERE query
     *
     * @param string $condition >,<, =>,=<, !=,=,LIKE and more
     * @param string $field
     * @param mixed $value
     *
     * @return $this
     */
    public function where(string $condition, string $field, $value)
    {
        $this->query = $this->query . ' WHERE ' . $field . ' ' . $condition . ' ?';
        $this->params[] = $value;
        return $this;
    }

    /**
     * Generate AND WHERE query
     *
     * @param string $condition >,<, =>,=<, !=,=,LIKE and more
     * @param string $field
     * @param mixed $value
     *
     * @return $this
     */
    public function andWhere(string $condition, string $field, $value)
    {
        $this->query = $this->query . ' AND ' . $field . ' ' . $condition . ' ?';
        $this->params[] = $value;
        return $this;
    }

    /**
     * Generate OR WHERE query
     *
     * @param string $condition >,<, =>,=<, !=,=,LIKE and more
     * @param string $field
     * @param mixed $value
     *
     * @return $this
     */
    public function orWhere(string $condition, string $field, $value)
    {
        $this->query = $this->query . ' OR ' . $field . ' ' . $condition . ' ?';
        $this->params[] = $value;
        return $this;
    }

    /**
     * Generate LIMIT query
     *
     * @param int $value value
     *
     * @return $this
     */
    public function limit(int $value)
    {
        $this->query = $this->query . ' LIMIT ' . $value;
        return $this;
    }

    /**
     * Generate OFFSET query
     *
     * @param int $value value
     *
     * @return $this
     */
    public function offset(int $value)
    {
        $this->query = $this->query . ' OFFSET ' . $value;
        return $this;
    }

    /**
     * Generate BETWEEN query
     *
     * @param string $field table field
     * @param mixed $min max value
     * @param mixed $max min value
     *
     * @return $this
     */
    public function between(string $field, $min, $max)
    {
        (preg_match("/WHERE|where /i", $this->query))
            ? $this->query = $this->query . ' AND ' . $field . ' ' . 'BETWEEN ' . '?' . ' AND ' . '?'
            : $this->query = $this->query . ' WHERE ' . $field . ' ' . 'BETWEEN ' . '?' . ' AND ' . '?';
        $this->params[] = $min;
        $this->params[] = $max;
        return $this;
    }

    /**
     * Generate BETWEEN query
     *
     * @param string $field table field
     * @param mixed $min max value
     * @param mixed $max min value
     *
     * @return $this
     */
    public function notBetween(string $field, $min, $max)
    {
        (preg_match("/WHERE|where /i", $this->query))
            ? $this->query = $this->query . ' AND ' . $field . ' ' . 'NOT BETWEEN ' . '?' . ' AND ' . '?'
            : $this->query = $this->query . ' WHERE ' . $field . ' ' . 'NOT BETWEEN ' . '?' . ' AND ' . '?';
        $this->params[] = $min;
        $this->params[] = $max;
        return $this;
    }

    /**
     * Generate OR BETWEEN query
     *
     * @param string $field table field
     * @param mixed $min max value
     * @param mixed $max min value
     *
     * @return $this
     */
    public function orBetween(string $field, $min, $max)
    {
        $this->query = $this->query . ' OR ' . $field . ' ' . 'BETWEEN ' . '?' . ' AND ' . '?';
        $this->params[] = $min;
        $this->params[] = $max;
        return $this;
    }

    /**
     * Generate OR BETWEEN NOT query
     *
     * @param string $field table field
     * @param mixed $min max value
     * @param mixed $max min value
     *
     * @return $this
     */
    public function orNotBetween(string $field, $min, $max)
    {
        $this->query = $this->query . ' OR ' . $field . ' ' . 'NOT BETWEEN ' . '?' . ' AND ' . '?';
        $this->params[] = $min;
        $this->params[] = $max;
        return $this;
    }

    /**
     * Generate IN query
     *
     * @param string $field table field
     * @param string|array $values values list or select query
     *
     * @return $this
     */
    public function in(string $field, $values)
    {
        if (is_array($values)) {
            $condition = $this->getInCondition($values);
            $query = (preg_match("/WHERE|where /i", $this->query))
                ? ' AND '
                : ' WHERE ';
        } else {
            $condition = $values;
        }
        $this->query .= $query . $field . ' ' . 'IN ' . $condition;
        return $this;
    }

    /**
     * Generate NOT IN query
     *
     * @param string $field table field
     * @param string|array $values values list or select query
     *
     * @return $this
     */
    public function notIn(string $field, $values)
    {
        if (is_array($values)) {
            $condition = $this->getInCondition($values);
            $query = (preg_match("/WHERE|where /i", $this->query))
                ? ' AND '
                : ' WHERE ';
        } else {
            $condition = $values;
        }
        $this->query .= $query . $field . ' ' . 'NOT IN ' . $condition;
        return $this;
    }

    /**
     * Generate OR IN query
     *
     * @param string $field table field
     * @param string|array $values values list or select query
     *
     * @return $this
     */
    public function orIn(string $field, $values)
    {
        if (is_array($values)) {
            $condition = $this->getInCondition($values);
            $query = (preg_match("/WHERE|where /i", $this->query))
                ? ' AND '
                : ' WHERE ';
        } else {
            $condition = $values;
        }
        $this->query .= $query . ' OR ' . $field . ' ' . ' IN ' . $condition;
        return $this;
    }

    /**
     * Generate OR NOT IN query
     *
     * @param string $field table field
     * @param string|array $values values list or select query
     *
     * @return $this
     */
    public function orNotIn(string $field, $values)
    {
        $condition = (is_array($values))
            ? $this->getInCondition($values)
            : $values;
        $this->query .= ' OR ' . $field . ' ' . ' NOT IN ' . $condition;
        return $this;
    }

    /**
     * Generate OR NOT IN query
     *
     * @param array $conditions conditions
     *
     * @return $this
     */
    public function orderBy(array $conditions)
    {
        $orderBy = ' ORDER BY ';
        $countConditions = count($conditions);
        $count = 0;
        foreach ($conditions as $key => $value) {
            $count++;
            if (!in_array(strtoupper($value), ['ASC', 'DESC'])) {
                throw new \PDOException('invalid order parameter ' . $value);
            }
            $orderBy .= $key . ' ' . $value;
            if ($countConditions !== $count) {
                $orderBy .= ',';
            }
        }
        $this->query = $this->query . $orderBy;
        return $this;
    }

    /**
     * Sort Asc
     *
     * @param string $value value
     *
     * @return $this
     */
    public function Asc(string $value)
    {
        $this->query = $this->query . ' ORDER BY ' . $value . ' ASC ';
        return $this;
    }

    /**
     * Sort Desc
     *
     * @param string $value value
     *
     * @return $this
     */
    public function Desc(string $value)
    {
        $this->query = $this->query . ' ORDER BY ' . $value . ' DESC ';
        return $this;
    }

    /**
     * Generate join query
     *
     * @param string $table subtable
     * @param string $key table id
     * @param string $subKey subTable id
     * @param string|null $type type join
     *
     * @return $this
     */
    public function join($table, $key, $subKey, $type = 'inner')
    {
        $this->query .= ' ' . strtoupper($type) . ' JOIN ' . $table . ' ON '
            . $key . '=' . $subKey;
        return $this;
    }

    /**
     * Generate left join query
     *
     * @param string $table subtable
     * @param string $key table id
     * @param string $subKey subTable id
     *
     * @return $this
     */
    public function leftJoin($table, $key, $subKey)
    {
        return $this->join($table, $key, $subKey, 'left');
    }

    /**
     * Generate right join query
     *
     * @param string $table subtable
     * @param string $key table id
     * @param string $subKey subTable id
     *
     * @return $this
     */
    public function rightJoin($table, $key, $subKey)
    {
        return $this->join($table, $key, $subKey, 'right');
    }

    public function union(DbInterface $query)
    {
        $checkClass = $query instanceof DbInterface;
        if (!$checkClass) {
            throw new \PDOException('Subquery is undefained class ', 500);
        }
        $stringQuery = $query->getRawSql();
        $this->params = array_merge($this->params, $query->getParams());
        $this->query .= ' UNION ' . $stringQuery;

        return $this;
    }

    /**
     * Generate HAVING query
     *
     * @param string $func having function
     * @param string $condition >,<, =>,=<, !=,=,LIKE and more
     * @param string $field
     * @param mixed $value
     *
     * @return $this
     */
    public function having($func, string $condition, string $field, $value)
    {
        $func = strtoupper($func);
        if (!in_array($func, ['SUM', 'AVG', 'COUNT', 'MIN', 'MAX'])) {
            throw new \PDOException('Undefined having operand');
        }
        $this->query = $this->query . ' HAVING ' . $func . '(' . $field . ')' . $condition . ' ?';
        $this->params[] = $value;
        return $this;
    }

    public function groupBy($value)
    {
        $this->query .= ' GROUP BY ' . $value;
        return $this;
    }

    /**
     * Get table fields
     *
     * @param string $tableName table name
     *
     * @return array
     */
    public function getFieldsName($tableName)
    {
        $queryString = 'SHOW COLUMNS FROM ' . $tableName ;
        $query = static::$dbClass->prepare($queryString);
        $query->execute($this->params);
        $result = [];
        $fields = $query->fetchAll();
        if(!empty($fields)) {
            foreach ($fields as $raw){
                $result[] = $raw['Field'];
            }
        }
        return $result;
    }

    /**
     * Array condition to string
     *
     * @param array $values values
     *
     * @return string
     */
    protected function getInCondition(array $values)
    {
        $countValues = count($values);
        $count = 0;
        $condition = '(';
        foreach ($values as $value) {
            $count++;
            $condition .= '?';
            ($count !== $countValues)
                ? $condition .= ','
                : $condition .= ')';
            $this->params[] = $value;
        }
        return $condition;
    }

    /**
     * Validate is Select exist in query
     */
    protected function checkSelectExist()
    {
        (preg_match("/SELECT|select /i", $this->query))
            ? $this->query .= ','
            : $this->query = 'SELECT ';
    }
}
