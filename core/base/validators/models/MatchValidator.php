<?php

namespace core\base\validators\models;

/**
 * In range validate rule class
 *
 * Class InValidator
 *
 * @package core\base\validators\models
 */
class MatchValidator extends BaseValidator
{
    /**
     * Validate method
     *
     * @return array
     *
     * @throws \Exception
     */
    public function validateRule()
    {
        if (!isset($this->additionParams['pattern'])) {
            throw new \Exception('Param range not found');
        }
        return (!is_string($this->value) || !preg_match($this->additionParams['pattern'], $this->value))
            ? [$this->fieldName => 'Invalid format value']
            : [];
    }
}
