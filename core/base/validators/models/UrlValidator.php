<?php

namespace core\base\validators\models;

/**
 * Url Validator
 *
 * Class Url
 *
 * @package core\base\validators\models
 */
class UrlValidator extends BaseValidator
{
    /**
     * Validate rule
     *
     * @return array
     */
    public function validateRule()
    {
        $regex = '|^http(s)?://[a-z0-9-]+(.[a-z0-9-]+)*(:[0-9]+)?(/.*)?$|i';
        return (!is_string($this->value) || !preg_match($regex, $this->value))
            ? [$this->fieldName => 'Invalid url']
            : [];
    }
}