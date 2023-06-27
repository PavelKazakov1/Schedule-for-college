<?php

namespace app\models;

use yii\db\ActiveRecord;
use yii\db\ActiveQuery;
use Yii;
use app\models\User;


class Teacher extends ActiveRecord
{
    public $subject;
    public $group_name; 
    public $weeks;
    public $hours_per_week;
    public $total_hours;
    public $total_of_semester; 

    public static function tableName()
    {
        return 'public.teacher';
    }

    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'id_teacher']);
    }

    public static function findLoadData($teacherId, $year)
    {
        $connection = Yii::$app->getDb();
        $command = $connection->createCommand('SELECT * FROM teacher_load(:teacher_id, :year)');
        $command->bindParam(':teacher_id', $teacherId);
        $command->bindParam(':year', $year);
        $result = $command->queryAll();
        Yii::info('Result variable: ' . print_r($result, true));
        $loadData = [];
        // Fetch the load data for the specified year and assign the values to the Teacher model properties
        foreach ($result as $row) {
            $loadItem = new Teacher();
            $loadItem->subject = $row['subject']; // Assign the subject value
            $loadItem->group_name = $row['group_name']; 
            $loadItem->weeks = $row['weeks'];
            $loadItem->hours_per_week = $row['hours_per_week'];
            $loadItem->total_hours = $row['total_hours'];
            // Assign other properties...
            $loadData[] = $loadItem;
        }

        return $loadData;
    }


    public function findLoadDataByTeacherId($teacherId)
    {
        $loadData = [];

        if ($teacherId !== null) {
            // Fetch the load data for the specified teacher
            $connection = Yii::$app->getDb();
            $command = $connection->createCommand('SELECT * FROM teacher_load(:teacher_id)');
            $command->bindParam(':teacher_id', $teacherId);
            $result = $command->queryAll();

            foreach ($result as $row) {
                $loadItem = new Teacher();
                $loadItem->subject = $row['subject'];
                $loadItem->group_name = $row['group_name'];
                $loadItem->weeks = $row['weeks'];
                $loadItem->hours_per_week = $row['hours_per_week'];
                $loadItem->total_of_semester = $loadItem->weeks * $loadItem->hours_per_week;

                $loadData[] = $loadItem;
            }
        }

        return $loadData;
    }  



}

?>