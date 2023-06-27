<?php

namespace app\models;

use yii\db\ActiveRecord;
use yii\db\ActiveQuery;

class Hours extends ActiveRecord
{
    public static function tableName()
    {
        return 'hours';
    }
}

?>