<?php

namespace core\base\validators\models;

/**
 * In range validate rule class
 *
 * Class InValidator
 *
 * @package core\base\validators\models
 */
class InValidator extends BaseValidator
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
        if (!isset($this->additionParams['range'])) {
            throw new \Exception('Param range not found');
        }
        return (!in_array($this->value, $this->additionParams['range']))
            ? [$this->fieldName => 'Must be in array range']
            : [];
    }
}
