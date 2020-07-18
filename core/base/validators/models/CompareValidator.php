<?php

namespace core\base\validators\models;

/**
 * Rule compare class
 *
 * Class CompareValidator
 *
 * @package core\base\validators\models
 */
class CompareValidator extends BaseValidator
{
    /**
     * @return array
     *
     * @throws \Exception
     */
    public function validateRule()
    {
        $result = [];
        if(!isset( $this->additionParams['compareValue'])){
            throw new \Exception('Compare value not found');
        }
        if(!isset( $this->additionParams['operator'])){
            throw new \Exception('Operator not found');
        }
        $compareValue = $this->additionParams['compareValue'];
        $operator = $this->additionParams['operator'];
        switch ($operator) {
            case '<':
                if (($this->value < $compareValue) == false) {
                    $result = [$this->fieldName => 'Must be < ' . $compareValue];
                }
                break;
            case '<=':
                if (($this->value <= $compareValue) == false) {
                    $result = [$this->fieldName => 'Must be <= ' . $compareValue];
                }
                break;
            case '>':
                if (($this->value > $compareValue) == false) {
                    $result = [$this->fieldName => 'Must be > ' . $compareValue];
                }
                break;
            case '>=':
                if (($this->value >= $compareValue) == false) {
                    $result = [$this->fieldName => 'Must be >= ' . $compareValue];
                }
                break;
            case '==':
                if (($this->value == $compareValue) == false) {
                    $result = [$this->fieldName => 'Must be == ' . $compareValue];
                }
                break;
            case '===':
                if (($this->value === $compareValue) == false) {
                    $result = [$this->fieldName => 'Must be === ' . $compareValue];
                }
                break;
            case '!=':
                if (($this->value != $compareValue) == false) {
                    $result = [$this->fieldName => 'Must be != ' . $compareValue];
                }
                break;
            case '!==':
                if (($this->value !== $compareValue) == false) {
                    $result = [$this->fieldName => 'Must be !== ' . $compareValue];
                }
                break;
            default:
                throw new \Exception('Undefined operator ' . $operator);

        }
        return $result;

    }
}
