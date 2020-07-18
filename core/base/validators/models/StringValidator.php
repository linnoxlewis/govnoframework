<?php

namespace core\base\validators\models;

/**
 * Rule string class
 *
 * Class RequiredValidator
 *
 * @package core\base\validators\models
 */
class StringValidator extends BaseValidator
{
    /**
     * Validate rule
     *
     * @return array
     */
    public function validateRule()
    {
        if (!is_string($this->value)) {
            return [$this->fieldName => 'Must be string'];
        }
        $checkLength = $this->checkLength();
        return (!empty($checkLength))
            ? $checkLength
            : [];

    }

    /**
     * Validate length string
     *
     * @return array
     */
    protected function checkLength()
    {
        $result = [];
        $message = $this->message();
        $length = strlen($this->value);
        if (isset($this->additionParams['length'])) {
            $min = $this->additionParams['length'][0];
            $max = $this->additionParams['length'][1];
            if ($length < $min) {
                $result = is_null($message)
                    ? [$this->fieldName => 'Length must > ' . $min]
                    : [$this->fieldName => $message];
            } elseif ($length > $max) {
                $result = is_null($message)
                    ? [$this->fieldName => 'Length must < ' . $max]
                    : [$this->fieldName => $message];
            }
        }
        return $result;
    }
}