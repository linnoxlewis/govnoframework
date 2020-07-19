<?php

namespace core\base\models;

use core\base\helpers\ArrayHelper;

/**
 * Class ActiveRecord
 *
 * @package core\base\models
 */
class ActiveRecord extends Model
{
    /**
     * db object
     *
     * @var object
     */
    protected $db;

    /**
     * Table name
     *
     * @var string
     */
    protected $tableName;

    /**
     * ActiveRecord constructor.
     */
    public function __construct()
    {
        $this->db = \App::$service->db;
        $class = new \ReflectionClass(get_called_class());
        $entity = $class->newInstance();
        foreach ($class->getProperties(\ReflectionProperty::IS_PUBLIC) as $prop) {
            if (isset($object[$prop->getName()])) {
                $prop->setValue($entity, $object[$prop->getName()]);
            }
        }
        $entity->initialize();
    }

    /**
     * Call method db
     *
     * @param string $name
     * @param array $arguments
     *
     * @return mixed
     * @throws \Exception
     */
    public function __call($name, $arguments)
    {
        return call_user_func_array([$this->db, $name], $arguments);
    }

    /**
     * Select method
     *
     * @param array $selectParams select params
     *
     * @return $this
     * @throws \ReflectionException
     */
    public function find(array $selectParams = ['*'])
    {
        $select = $this->getSelectParams($selectParams);
        $this->db->select($select)->from($this->getTableName());
        return $this;
    }

    /**
     * Find all value
     *
     * @param array $whereParams where conditions
     * @param array $selectParams select params
     *
     * @return mixed
     * @throws \ReflectionException
     */
    public function findAll(array $whereParams, array $selectParams = ['*'])
    {
        $select = $this->getSelectParams($selectParams);
        $this->db->select($select)->from($this->getTableName());
        $this->getWhereParams($whereParams);
        return $this->db->all();
    }

    /**
     * Find one value
     *
     * @param array $whereParams where conditions
     * @param array $selectParams select params
     *
     * @return mixed
     * @throws \ReflectionException
     */
    public function findOne(array $whereParams, array $selectParams = ['*'])
    {
        $select = $this->getSelectParams($selectParams);
        $this->db->select($select)->from($this->getTableName());
        $this->getWhereParams($whereParams);
        return $this->db->one();
    }




    /**
     * Insert or update
     *
     * @param bool $validate
     */
    public function save($validate = true)
    {
        $class = new \ReflectionClass($this);
        $tableName = $this->getTableName();

        $propsToImplode = [];
        foreach ($class->getProperties(\ReflectionProperty::IS_PUBLIC) as $property) {
            $propertyName = $property->getName();
            $propsToImplode[] = '`' . $propertyName . '` = "' . $this->{$propertyName} . '"';
        }

        $setClause = implode(',', $propsToImplode);
        $sqlQuery = '';

        if ($this->id > 0) {
            $sqlQuery = 'UPDATE `' . $tableName . '` SET ' . $setClause . ' WHERE id = ' . $this->id;
        } else { // иначе  нам нужно вставить новый объект в бд
            $sqlQuery = 'INSERT INTO `' . $tableName . '` SET ' . $setClause . ', id = ' . $this->id;
        }

        $result = self::$db->exec($sqlQuery);

        if (self::$db->errorCode()) {
            throw new \Exception(self::$db->errorInfo()[2]);
        }

        return $result;
    }

    /**
     * inicialize table
     *
     * @return string|null
     */
    public static function tableName()
    {
        return null;
    }

    /**
     * @param array $params
     *
     * @return string
     */
    protected function getSelectParams(array $params)
    {
        return implode(',', $params);
    }

    /**
     * Get where query
     *
     * @param array $whereParams
     */
    protected function getWhereParams(array $whereParams)
    {
        if (!ArrayHelper::isMultiArray($whereParams)) {
            $condition = $whereParams[0];
            $field = $whereParams[1];
            $value = $whereParams[2];
            $this->db->where($condition, $field, $value);
        } else {
            $count = 0;
            foreach ($whereParams as $param) {
                $count++;
                $condition = $param[0];
                $field = $param[1];
                $value = $param[2];
                ($count > 1)
                    ? $this->db->andWhere($condition, $field, $value)
                    : $this->db->where($condition, $field, $value);
            }
        }
    }

    /**
     * Get table name
     *
     * @return string|null
     * @throws \ReflectionException
     */
    protected function getTableName()
    {
        $tableName = static::tableName();
        $this->tableName = (empty($tableName))
            ? (new \ReflectionClass(get_called_class()))->getShortName()
            : $tableName;
        return $this->tableName;
    }

    protected static function morph(array $object)
    {

      // return $entity;
    }
}
