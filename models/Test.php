<?php

namespace models;

use core\base\models\Model;

class Test extends Model
{
    public $filedOne;

    public $filedTwo;

    public $filedThree;

    public $fieldBool;

    public $stringValue;

    public $compareValue;

    public $emailValue;

    public $ipValue;

    public $arrayValue;

    public $inValue;

    public $matchValue;

    public $safeValue;

    public $urlValue;

    
    public function validateRules(): array
    {
        return [
            ['filedOne', 'required'],
            ['filedThree', 'float', 'min' => 10, 'max' => 20],
            ['filedTwo', 'integer', 'min' => 10, 'max' => 20],
            ['fieldBool','boolean','message' => 'test'],
            ['stringValue','string','length' => [5,7]],
            ['compareValue','compare', 'operator' => '>' ,'compareValue' => 1],
            ['emailValue','email'],
            ['ipValue','ip'],
            ['safeValue','safe'],
            ['arrayValue','array','count' => 3 , 'valueExist' => [5,55,555], 'keyExist' => ['i','id']],
            ['inValue','in','range' => [1,2,3]],
            ['matchValue','match','pattern' => '123'],
            ['urlValue','url']
        ];
    }

    public function getAttributeLabels(): array
    {
        return [
            'filedOne' => 'test1',
            'filedTwo' => 'test2'
        ];
    }

    public function fields()
    {
        return [
            'filedOne' => function () {
                return $this->filedOne . ' ' . 'test23';
            },
        ];
    }
}