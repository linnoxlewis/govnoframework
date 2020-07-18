<?php

namespace core\base\validators\models;

/**
 * Rule real class
 *
 * Class RealValidator
 *
 * @package core\base\validators\models
 */
class RealValidator extends BaseValidator
{
    /**
     * Validate rule
     *
     * @return array
     */
    public function validateRule()
    {
        if (!is_real($this->value)) {
            return [$this->fieldName => 'Must be real'];
        }
        $checkMinMax = $this->checkMinMax();
        return (!empty($checkMinMax))
            ? $checkMinMax
            : [];
    }
}