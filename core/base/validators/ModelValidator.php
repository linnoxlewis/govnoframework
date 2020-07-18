<?php

namespace core\base\validators;

use core\base\abstracts\ModelValidatorInterface;

/**
 * Model Validator
 *
 * Class ModelValidator
 *
 * @package core\base\validators
 */
class ModelValidator implements ModelValidatorInterface
{
    /**
     * Properties
     *
     * @var array
     */
    protected static $properties;

    /**
     * List errors
     *
     * @var array
     */
    protected $result = [];

    /**
     * Validate rules
     *
     * @param array $rules      rules list
     * @param array $properties properties list
     *
     * @return array
     * @throws \Exception
     */
    public function validate(array $rules, array $properties)
    {
        static::$properties = $properties;
        foreach ($rules as $rule) {
            $field = $rule[0];
            $type = $rule[1];
            $params = array_slice($rule, 1);
            $value = $this->getValue($field);
            $key = array_search(strtolower($type),$this->getRulesType());
            if ($key === false) {
                throw new \Exception('Undefined validation type: ' . $type);
            }
            $typeClass = 'core\base\validators\models\\' . ucfirst($this->getRulesType()[$key]) . 'Validator';
            $validator = new $typeClass($field,$params,$value);
            $result = ($type !== ModelValidatorInterface::REQUIRED_TYPE && empty($value))
            ? []
            : $validator->validate();
            if (!empty($result)){
                $this->result[]= $result;
            }
        }
        return $this->result;
    }

    /**
     * Get list rules
     *
     * @return array
     */
    protected function getRulesType()
    {
        return [
            ModelValidatorInterface::REQUIRED_TYPE,
            ModelValidatorInterface::INT_TYPE,
            ModelValidatorInterface::FLOAT_TYPE,
            ModelValidatorInterface::STRING_TYPE,
            ModelValidatorInterface::BOOL_TYPE,
            ModelValidatorInterface::COMPARE_TYPE,
            ModelValidatorInterface::EMAIL_TYPE,
            ModelValidatorInterface::REAL_TYPE,
            ModelValidatorInterface::DOUBLE_TYPE,
            ModelValidatorInterface::IP_TYPE,
            ModelValidatorInterface::ARRAY_TYPE,
            ModelValidatorInterface::IN_TYPE,
            ModelValidatorInterface::URL_TYPE,
            ModelValidatorInterface::SAFE_TYPE,
            ModelValidatorInterface::MATCH_TYPE,
        ];
    }

    /**
     * Get field value
     *
     * @param string $field field
     *
     * @return mixed
     * @throws \Exception
     */
    protected function getValue($field)
    {
        if (!array_key_exists($field, static::$properties)) {
            throw new \Exception('Undefinded field ' . $field);
        }
        return static::$properties[$field];
    }
}
