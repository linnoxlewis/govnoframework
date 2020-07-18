<?php

namespace core\base\services\db;

use core\base\abstracts\BaseService;
use core\base\abstracts\DbInterface;

/**
 * Class base DB
 *
 * @package core\base\db
 */
class DB extends BaseService
{
    /**
     * Concrete realization db
     *
     * @var DbInterface
     */
    protected $db;

    /**
     * DB constructor.
     *
     * @param DbInterface $db
     * @param string $host
     * @param int $port
     * @param string $user
     * @param string $password
     * @param string $type
     * @param string $database
     * @param array $options
     *
     * @throws \Exception
     */
    public function __construct(DbInterface $db, string $host, int $port,string $user, string $password, string $type, string $database,$options = [])
    {
        $this->db = $db->connection($host, $port,$user,$password,$type,$database,$options);
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
}
