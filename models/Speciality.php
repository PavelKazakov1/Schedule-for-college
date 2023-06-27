<?php

namespace app\models;

use yii\db\ActiveRecord;
use yii\db\ActiveQuery;

class Speciality extends ActiveRecord
{
    public static function tableName()
    {
        return 'speciality';
    }

    public function getGroups(): ActiveQuery
    {
        return $this->hasMany(Group::class, ['number_of_speciality' => 'number_of_speciality']);
    }

    public function getCurricula(): ActiveQuery
    {
        return $this->hasMany(Curriculum::class, ['number_of_speciality' => 'number_of_speciality']);
    }

}

?>