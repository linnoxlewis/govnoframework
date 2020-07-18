<?php

namespace core\base\abstracts;

/**
 * Interface ModelValidator
 *
 * @package core\base\abstracts
 */
interface ModelValidateInterface
{
    /**
     * Validate rules
     *
     * @return bool
     */
    public function validateRules(): array ;

    /**
     * Validate
     *
     * @return bool
     */
    public function validate();

}
