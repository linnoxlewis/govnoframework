<?php

namespace core\base\validators\models;

/**
 * Base class validator class
 *
 * Class BaseValidator
 *
 * @package core\base\validators\models
 */
abstract class BaseValidator
{
    /**
     * Property name
     *
     * @var string
     */
    public $fieldName;

    /**
     * Params validation
     *
     * @var array
     */
    public $additionParams;

    /**
     * Property value
     *
     * @var mixed
     */
    public $value;

    /**
     * BaseValidator constructor.
     *
     * @param string $fieldName
     * @param array  $additionParams
     * @param mixed  $value
     */
    public function __construct($fieldName, $additionParams, $value)
    {
        $this->fieldName = $fieldName;
        $this->additionParams = $additionParams;
        $this->value = $value;
    }

    /**
     * Get custom message
     *
     * @return mixed|null
     */
    protected function message()
    {
        return (isset($this->additionParams['message']) && is_string($this->additionParams['message']))
            ? $this->additionParams['message']
            : null;
    }

    /**
     * Validate min or max value
     *
     * @return array
     */
    protected function checkMinMax()
    {
        $result = [];
        $message = $this->message();
        if (array_key_exists('min', $this->additionParams) && $this->value < $this->additionParams['min']) {
            $result = is_null($message)
                ? [$this->fieldName => 'Must > ' . $this->additionParams['min']]
                : [$this->fieldName => $message];
        }
        if (array_key_exists('max', $this->additionParams) && $this->value > $this->additionParams['max']) {
            $result = is_null($message)
                ? [$this->fieldName => 'Must < ' . $this->additionParams['max']]
                : [$this->fieldName => $message];
        }

        return $result;
    }

    /**
     * Validate method
     *
     * @return array
     */
    public function validate()
    {
        $message = $this->message();
        $result = $this->validateRule();
        return (!is_null($message))
            ? [$this->fieldName => $message]
            : $result;
    }

    /**
     * Validate rule
     *
     * @return array
     */
    abstract function validateRule();
}
