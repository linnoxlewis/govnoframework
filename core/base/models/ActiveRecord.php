<?php

namespace core\base\models;

class ActiveRecord extends Model
{
    protected $db;

    protected $tableName;

    public function __construct()
    {
        $this->db = \App::$service->db;
    }

    protected function getTableName()
    {
        $tableName = static::tableName();
        $this->tableName = (empty($tableName))
            ? (new \ReflectionClass(get_called_class()))->getShortName()
            : $tableName;
        return $this->tableName;
    }

    /**
     * Call method db
     *
     * @param string $name
     * @param array  $arguments
     *
     * @return mixed
     * @throws \Exception
     */
    public function __call($name, $arguments)
    {
        if (!method_exists($this->db, $name) && !in_array($name,get_class_methods($this->db))) {
            throw new \Exception('Method ' . $name . ' not found ');
        }
        return call_user_func_array([$this->db, $name], $arguments);
    }










    public function find(array $fields = null)
    {
        $this->db->select($fields)->from($this->getTableName());
        return $this;
    }

    public function where(array $condition)
    {
        $this->db->where($condition[0] , $condition[1],$condition[2]);
        return $this;
    }

    public function one()
    {
        return $this->db->getRawSql();

    }

    public function findAll(array $params = null)
    {

    }

    public static function tableName()
    {
        return null;
    }

}