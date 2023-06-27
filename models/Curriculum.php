<?php

namespace app\models;

use yii\db\ActiveRecord;
use yii\db\ActiveQuery;

class Curriculum extends ActiveRecord
{
    public static function tableName()
    {
        return 'сurriculum';
    }
    
    
    public function getSpeciality(): ActiveQuery
    {
        return $this->hasOne(Speciality::class, ['number_of_speciality' => 'number_of_speciality']);
    }
}


?>