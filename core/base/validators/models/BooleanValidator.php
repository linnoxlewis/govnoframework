<?php

namespace core\base\validators\models;

/**
 * Rule boolean class
 *
 * Class BooleanValidator
 *
 * @package core\base\validators\models
 */
class BooleanValidator extends BaseValidator
{
    /**
     * Validate rule
     *
     * @return array
     */
    public function validateRule()
    {
        return (!is_bool($this->value) && $this->value !== 1 && $this->value !== 0)
            ? [$this->fieldName => 'Must be boolean']
            : [];
    }
}
