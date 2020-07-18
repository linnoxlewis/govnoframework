<?php

namespace core\base\abstracts;

/**
 * Interface ModelLabelsInterface
 *
 * @package core\base\abstracts
 */
interface ModelAttributesInterface
{
    /**
     * Get property label
     *
     * @param string $property
     *
     * @return mixed|null
     */
    public function getAttributeLabel($property);


    /**
     * Get attributes label list
     *
     * @return array
     */
    public function getAttributeLabels(): array;

    /**
     * Get all attributes
     *
     * @return array
     * @throws \ReflectionException
     */
    public function attributes();

    /**
     * Validate exist attribute
     *
     * @param string $attribute
     *
     * @return bool
     * @throws \ReflectionException
     */
    public function hasAttribute($attribute);
}
