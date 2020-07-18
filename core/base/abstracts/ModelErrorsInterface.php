<?php

namespace core\base\abstracts;

/**
 *
 *
 * Interface ModelValidator
 *
 * @package core\base\abstracts
 */
interface ModelErrorsInterface
{
    /**
     * Get list errors
     *
     * @return array
     */
    public function errors();

    /**
     * Get first error
     *
     * @return mixed
     */
    public function getFirstError();

    /**
     * Get last error
     *
     * @return mixed
     */
    public function getLastError();

    /**
     * Is model has error
     *
     * @return mixed
     */
    public function hasErrors();

    /**
     * delete oll errors
     *
     * @return mixed
     */
    public function clearErrors();

}
