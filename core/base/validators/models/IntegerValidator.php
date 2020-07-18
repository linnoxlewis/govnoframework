<?php

namespace core\base\validators\models;

/**
 * Rule integer class
 *
 * Class RequiredValidator
 *
 * @package core\base\validators\models
 */
class IntegerValidator extends BaseValidator
{
    /**
     * Validate rule
     *
     * @return array
     */
    public function validateRule()
    {
        if (!is_int($this->value)) {
            return [$this->fieldName => 'Must be integer'];
        }
        $checkMinMax = $this->checkMinMax();
        return (!empty($checkMinMax))
            ? $checkMinMax
            : [];
    }
}