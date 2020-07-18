<?php

namespace core\base\validators\models;

/**
 * Email Validator
 *
 * Class EmailValidator
 *
 * @package core\base\validators\models
 */
class EmailValidator extends BaseValidator
{
    /**
     * Validate rule
     *
     * @return array
     */
    public function validateRule()
    {
        $regex = '/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/i';
        return (!is_string($this->value) || !preg_match($regex, $this->value))
                ? [$this->fieldName => 'Invalid email']
                : [];
    }
}