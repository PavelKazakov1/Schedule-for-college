<?php

namespace app\models;

use yii\db\ActiveRecord;

class Subject extends ActiveRecord{

    public static function tableName()
    {
        return 'subject';
    }
}