<?php

namespace core\base\abstracts;

/**
 * Interface DbInterface
 *
 * @package core\base\abstracts
 */
interface DbInterface
{
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
    public function connection(string $host, int $port, string $user, string $password, string $type, string $database, $options = []);

    /**
     * Type sort
     *
     * @var string
     */
    const SORT_DESC = 'DESC';

    /**
     * Type sort
     *
     * @var string
     */
    const SORT_ASC = 'ASC';

    /**
     * Generate Select query
     *
     * @param null|string|array $fields table fields
     * @param bool $distinct is distinct request
     *
     * @return $this
     */
    public function select($fields = null, $distinct = false);

    /**
     * Generate Insert query
     *
     * @param string $tableName table name
     * @param array $values insert values
     *
     * @return $this
     */
    public function insert(string $tableName, array $values);

    /**
     * Generate Update query
     *
     * @param string $tableName table
     * @param array $fields table fields
     *
     * @return $this
     */
    public function update(string $tableName, array $fields);

    /**
     * Generate Delete query
     *
     * @param string $tableName table name
     *
     * @return $this
     */
    public function delete($tableName);

    /**
     * Select min field
     *
     * @param string $field table field
     * @return $this
     */
    public function min(string $field);

    /**
     * Select max field
     *
     * @param string $field table field
     *
     * @return $this
     */
    public function max(string $field);

    /**
     * Select avg field
     *
     * @param string $field table field
     *
     * @return $this
     */
    public function avg(string $field);

    /**
     * Select sum fields
     *
     * @param string $field table field
     *
     * @return $this
     */
    public function sum(string $field);

    /**
     * Select count fields
     *
     * @param string|null $field table field
     *
     * @return $this
     */
    public function count(string $field = null);


    /**
     * Execute query
     *
     * @return bool
     */
    public function execute();

    /**
     * Get SQL string
     *
     * @return string
     */
    public function getRawSql();

    /**
     * Execute string query
     *
     * @param string $query
     * @return mixed
     */
    public function query($query);

    /**
     * get one result query
     *
     * @return mixed
     */
    public function one();

    /**
     * get all result query
     *
     * @return mixed
     */
    public function all();


    /**
     * Generate FROM query
     *
     * @param string $tablename table
     *
     * @return $this
     */
    public function from(string $tablename);


    /**
     * Generate WHERE query
     *
     * @param string $condition >,<, =>,=<, !=,=,LIKE and more
     * @param string $field
     * @param mixed $value
     *
     * @return $this
     */
    public function where(string $condition, string $field, $value);

    /**
     * Generate AND WHERE query
     *
     * @param string $condition >,<, =>,=<, !=,=,LIKE and more
     * @param string $field
     * @param mixed $value
     *
     * @return $this
     */
    public function andWhere(string $condition, string $field, $value);

    /**
     * Generate OR WHERE query
     *
     * @param string $condition >,<, =>,=<, !=,=,LIKE and more
     * @param string $field
     * @param mixed $value
     *
     * @return $this
     */
    public function orWhere(string $condition, string $field, $value);

    /**
     * Generate LIMIT query
     *
     * @param int $value value
     *
     * @return $this
     */
    public function limit(int $value);

    /**
     * Generate OFFSET query
     *
     * @param int $value value
     *
     * @return $this
     */
    public function offset(int $value);

    /**
     * Generate BETWEEN query
     *
     * @param string $field table field
     * @param mixed $min max value
     * @param mixed $max min value
     *
     * @return $this
     */
    public function between(string $field, $min, $max);

    /**
     * Generate BETWEEN query
     *
     * @param string $field table field
     * @param mixed $min max value
     * @param mixed $max min value
     *
     * @return $this
     */
    public function notBetween(string $field, $min, $max);

    /**
     * Generate OR BETWEEN query
     *
     * @param string $field table field
     * @param mixed $min max value
     * @param mixed $max min value
     *
     * @return $this
     */
    public function orBetween(string $field, $min, $max);

    /**
     * Generate OR BETWEEN NOT query
     *
     * @param string $field table field
     * @param mixed $min max value
     * @param mixed $max min value
     *
     * @return $this
     */
    public function orNotBetween(string $field, $min, $max);

    /**
     * Generate IN query
     *
     * @param string $field table field
     * @param string|array $values values list or select query
     *
     * @return $this
     */
    public function in(string $field, $values);

    /**
     * Generate NOT IN query
     *
     * @param string $field table field
     * @param string|array $values values list or select query
     *
     * @return $this
     */
    public function notIn(string $field, $values);

    /**
     * Generate OR IN query
     *
     * @param string $field table field
     * @param string|array $values values list or select query
     *
     * @return $this
     */
    public function orIn(string $field, $values);

    /**
     * Generate OR NOT IN query
     *
     * @param string $field table field
     * @param string|array $values values list or select query
     *
     * @return $this
     */
    public function orNotIn(string $field, $values);

    /**
     * Generate OR NOT IN query
     *
     * @param array $conditions conditions
     *
     * @return $this
     */
    public function orderBy(array $conditions);

    /**
     * Sort Asc
     *
     * @param string $value value
     *
     * @return $this
     */
    public function Asc(string $value);

    /**
     * Sort Desc
     *
     * @param string $value value
     *
     * @return $this
     */
    public function Desc(string $value);

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
    public function join($table, $key, $subKey, $type = 'inner');

    /**
     * Generate left join query
     *
     * @param string $table subtable
     * @param string $key table id
     * @param string $subKey subTable id
     *
     * @return $this
     */
    public function leftJoin($table, $key, $subKey);

    /**
     * Generate right join query
     *
     * @param string $table subtable
     * @param string $key table id
     * @param string $subKey subTable id
     *
     * @return $this
     */
    public function rightJoin($table, $key, $subKey);
}
