<?php

namespace core\base\validators\models;

/**
 * Rule required class
 *
 * Class RequiredValidator
 *
 * @package core\base\validators\models
 */
class RequiredValidator extends BaseValidator
{
    /**
     * Validate rule
     *
     * @return array
     */
    public function validateRule()
    {
        return (empty($this->value))
             ? [$this->fieldName => 'Must be required']
             : [];
    }
}
