<?php

namespace models;

use core\base\models\ActiveRecord;
use core\base\models\Model;

class TestActiveRecord extends ActiveRecord
{
    public static function tableName()
    {
        return 'users';
    }
}