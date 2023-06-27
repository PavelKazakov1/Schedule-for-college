<?php

namespace app\models;

use yii\db\ActiveRecord;
use Yii\db\ActiveQuery;

class CurriculumData extends ActiveRecord
{
    public static function tableName()
    {
        return 'curriculum_data';
    }
    
    public function getCurriculum(): ActiveQuery
    {
        return $this->hasOne(Curriculum::class, ['id_of_curriculum' => 'id_of_curriculum']);
    }
    
    
    public function getSubject()
    {
        return $this->hasOne(Subject::class, ['subject_id' => 'subject_id']);
    }

    
    public function getTeacher(): ActiveQuery
    {
        return $this->hasOne(Teacher::class, ['id_teacher' => 'id_teacher']);
    }

    public function getSchedule(): ActiveQuery
    {
        return $this->hasMany(Schedule::class, ['id_of_curriculum_data' => 'id_of_curriculum_data']);
    }

}

?>