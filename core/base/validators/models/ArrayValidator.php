<?php

namespace core\base\validators\models;

/**
 * Rule array class
 *
 * Class ArrayValidator
 *
 * @package core\base\validators\models
 */
class ArrayValidator extends BaseValidator
{
    /**
     * Validate rule
     *
     * @return array
     */
    public function validateRule()
    {
        $result = [];
        if (!is_array($this->value)) {
            return [$this->fieldName => 'Must be array'];
        }
        if (isset($this->additionParams['count'])) {
            $resultCount = $this->checkCount();
            if (!empty($resultCount)) {
                $result[] = $resultCount;
            }
        }
        if (isset($this->additionParams['valueExist'])) {
            $resultExist = $this->checkExistvalue();
            if (!empty($resultExist)) {
                $result[] = $resultExist;
            }
        }
        if (isset($this->additionParams['keyExist'])) {
            $resultKeyExist = $this->checkExistKey();
            if (!empty($resultKeyExist)) {
                $result[] = $resultKeyExist;
            }
        }

        return $result;
    }

    /**
     * Check count array
     *
     * @return array
     */
    protected function checkCount()
    {
        return (count($this->value) !== $this->additionParams['count'])
            ? ['field' => 'Count must be ' . $this->additionParams['count']]
            : [];
    }

    /**
     * Check exist element in array
     *
     * @return array
     */
    protected function checkExistValue()
    {
        $result = [];
        if (!is_array($this->additionParams['valueExist'])) {
            if (!in_array($this->additionParams['valueExist'], $this->value)) {
                return ['field' => 'Element ' . $this->additionParams['valueExist'] . ' mus be in this array'];
            }
        } else {
            foreach ($this->additionParams['valueExist'] as $exist) {
                if (!in_array($exist, $this->value)) {
                    $exist = false;
                } else {
                    $exist = true;
                    break;
                }
            }
            if (!$exist) {
                $result = ['field' => 'Elements ' . implode(',', $this->additionParams['valueExist']) . ' mus be in this array'];
            }
        }
        return $result;
    }

    /**
     * Check exist key in array
     *
     * @return array
     */
    protected function checkExistKey()
    {
        $result = [];
        if (!is_array($this->additionParams['keyExist'])) {
            if (!array_key_exists($this->additionParams['keyExist'], $this->value)) {
                return ['field' => 'Key ' . $this->additionParams['keyExist'] . ' mus be in this array'];
            }
        } else {
            foreach ($this->additionParams['keyExist'] as $exist) {
                if (!array_key_exists($exist, $this->value)) {
                    $exist = false;
                } else {
                    $exist = true;
                    break;
                }
            }
            if (!$exist) {
                $result = ['field' => 'Keys ' . implode(',', $this->additionParams['keyExist']) . ' mus be in this array'];
            }
        }
        return $result;
    }
}
