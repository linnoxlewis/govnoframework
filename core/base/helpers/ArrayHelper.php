<?php
namespace core\base\helpers;

class ArrayHelper
{
    public static function isMultiArray($array)
    {
        return count($array) != count($array, 1);
    }
}