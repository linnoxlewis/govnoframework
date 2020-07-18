<?php

namespace core\base\validators\models;

/**
 * Ip Validator
 *
 * Class IpValidator
 *
 * @package core\base\validators\models
 */
class IpValidator extends BaseValidator
{
    /**
     * Validate rule
     *
     * @return array
     */
    public function validateRule()
    {
        $regex = '/^\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}\z/';
        return (!is_string($this->value) || !preg_match($regex, $this->value))
            ? [$this->fieldName => 'Invalid ip']
            : [];
    }
}