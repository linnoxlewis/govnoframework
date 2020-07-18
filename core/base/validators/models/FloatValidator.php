<?php

namespace core\base\validators\models;

/**
 * Rule float class
 *
 * Class FloatValidator
 *
 * @package core\base\validators\models
 */
class FloatValidator extends BaseValidator
{
    /**
     * Validate rule
     *
     * @return array
     */
    public function validateRule()
    {
        if (!is_float($this->value)) {
            return [$this->fieldName => 'Must be float'];
        }
        $checkMinMax = $this->checkMinMax();
        return (!empty($checkMinMax))
            ? $checkMinMax
            : [];
    }
}