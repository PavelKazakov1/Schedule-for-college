<?php
namespace app\models;

use yii\db\ActiveRecord;
use yii\db\ActiveQuery;

class Group extends ActiveRecord
{
    public static function tableName()
    {
        return 'groups';
    }

    public function getSpeciality(): ActiveQuery
    {
        return $this->hasOne(Speciality::class, ['number_of_speciality' => 'number_of_speciality']);
    }

    public function getSchedules(): ActiveQuery
    {
        return $this->hasMany(Schedule::class, ['id_group' => 'id_group']);
    }
}

?>