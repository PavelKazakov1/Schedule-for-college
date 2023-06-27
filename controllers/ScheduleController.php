<?php

namespace app\controllers;

use app\models\Schedule;
use app\models\Group;
use app\models\Speciality;
use yii\web\Controller;
use Yii;
use yii\helpers\Html;
use yii\web\Request;
use yii\filters\AccessControl;

class ScheduleController extends Controller
{
    

    public function actionIndex()
    {
        $specialties = Speciality::find()->all();
        $groups = Group::find()->all();

        $scheduleData = null;
        $displayData = []; 
        $daysOfWeek = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday']; // Define the days of the week

        if (Yii::$app->request->isPost) {
            $specialtyNumber = Yii::$app->request->post('specialties');
            $groupName = Yii::$app->request->post('groups');
            $scheduleData = $this->getScheduleData($specialtyNumber, $groupName);

            
            for ($lessonNumber = 1; $lessonNumber <= 6; $lessonNumber++) {
                $displayRow = ['lesson' => $lessonNumber];
                foreach ($daysOfWeek as $dayOfWeek) {
                    $displayRow[$dayOfWeek] = $this->getLessonSubject($dayOfWeek, $lessonNumber, $scheduleData);
                }
                $displayData[] = $displayRow;
            }
        }

        return $this->render('index', [
            'specialities' => $specialties,
            'groups' => $groups,
            'displayData' => $displayData, 
        ]);
    }

    private function getScheduleData($specialtyNumber, $groupName)
    {
        $connection = Yii::$app->getDb();
        $command = $connection->createCommand("select * from display_group_schedule(:groupName)");
        $command->bindValue(':groupName', $groupName);
        $scheduleData = $command->queryAll();
        return $scheduleData;
    }

    public function getLessonSubject($dayOfWeek, $lesson, $scheduleData)
    {
        foreach ($scheduleData as $schedule) {
            if ($schedule['day_of_week'] === $dayOfWeek && $schedule['lesson'] === $lesson) {
                return Html::encode($schedule['subject']);
            }
        }
        return ''; 
    }
}



?>