<?php

namespace core\base\validators\models;

/**
 * Rule double class
 *
 * Class DoubleValidator
 *
 * @package core\base\validators\models
 */
class DoubleValidator extends BaseValidator
{
    /**
     * Validate rule
     *
     * @return array
     */
    public function validateRule()
    {
        if (!is_double($this->value)) {
            return [$this->fieldName => 'Must be double'];
        }
        $checkMinMax = $this->checkMinMax();
        return (!empty($checkMinMax))
            ? $checkMinMax
            : [];
    }
}