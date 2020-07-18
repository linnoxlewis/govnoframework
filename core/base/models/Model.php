<?php

namespace core\base\models;

use core\base\abstracts\ModelErrorsInterface;
use core\base\abstracts\ModelAttributesInterface;
use core\base\abstracts\ModelValidateInterface;
use core\base\abstracts\ModelValidatorInterface;

/**
 * Class Model
 *
 * @package core\base\models
 */
class Model implements ModelErrorsInterface, ModelAttributesInterface, ModelValidateInterface
{
    /***
     * Model errors
     *
     * @var array
     */
    protected $errors = [];

    /**
     * Get property label
     *
     * @param string $property
     *
     * @return mixed|null
     */
    public function getAttributeLabel($property)
    {
        $labels = $this->getAttributeLabels();
        return isset($labels[$property]) ? $labels[$property] : null;
    }

    /**
     * Get attributes label list
     *
     * @return array
     */
    public function getAttributeLabels(): array
    {
        return [];
    }

    /**
     * Get validate rules
     *
     * @return array
     */
    public function validateRules(): array
    {
        return [];
    }

    /**
     * Validate properties
     *
     * @return bool
     * @throws \ReflectionException
     */
    public function validate()
    {
        $rules = $this->validateRules();
        $validator = \App::$container->get(ModelValidatorInterface::class);
        $result = $validator->validate($rules, get_object_vars($this));
        if(!empty($result)) {
            $this->errors = $result;
            return false;
        } else {
            return true;
        }
    }

    /**
     * Get all attributes
     *
     * @return array
     * @throws \ReflectionException
     */
    public function attributes()
    {
        $class = new \ReflectionClass($this);
        $attributes = [];
        foreach ($class->getProperties(\ReflectionProperty::IS_PUBLIC) as $property) {
            if (!$property->isStatic()) {
                $attributes[] = $property->getName();
            }
        }

        return $attributes;
    }

    /**
     * Validate exist attribute
     *
     * @param string $attribute
     *
     * @return bool
     * @throws \ReflectionException
     */
    public function hasAttribute($attribute)
    {
        $attributes = $this->attributes();
        return in_array($attribute, $attributes);
    }

    /**
     * Get return fields
     *
     * @return array|false
     * @throws \ReflectionException
     */
    public function fields()
    {
        $fields = $this->attributes();
        return array_combine($fields, $fields);
    }

    /**
     * Get list errors
     *
     * @return array
     */
    public function errors()
    {
        return $this->errors;
    }

    /**
     * Get first error
     *
     * @return mixed
     */
    public function getFirstError()
    {
        return array_shift($this->errors);
    }

    /**
     * Get last error
     *
     * @return mixed
     */
    public function getLastError()
    {
        return array_pop($this->errors);
    }

    /**
     * Is model has error
     *
     * @return mixed
     */
    public function hasErrors()
    {
        return !empty($this->errors);
    }

    /**
     * delete oll errors
     *
     * @return void
     */
    public function clearErrors()
    {
        $this->errors = [];
    }
}