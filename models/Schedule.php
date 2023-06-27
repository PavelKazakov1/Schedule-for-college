<?php

namespace app\models;

use yii\db\ActiveRecord;
use yii\db\ActiveQuery;
use app\models\Group;
use app\models\CurriculumData;


class Schedule extends ActiveRecord
{
    public static function tableName()
    {
        return 'schedule';
    }

    private $_subject;

    public function getSubject()
    {
        return $this->_subject;
    }

    public function setSubject($subject)
    {
        $this->_subject = $subject;
    }

    
    public function getGroup()
    {
        return $this->hasOne(Group::class, ['id_group' => 'id_group']);
    }
    
    public function getCurriculumData()
    {
        return $this->hasOne(CurriculumData::class, ['id_of_curriculum_data' => 'id_of_curriculum_data'])
            ->via('group');
    }
    


    
    public static function hasScheduleForGroup($groupId)
    {
        $schedule = self::findOne(['id_group' => $groupId]);
        return $schedule !== null;
    }
}

?>