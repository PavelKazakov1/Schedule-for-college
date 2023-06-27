<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Group;
use app\models\Speciality;
use yii\helpers\Html;
use app\models\Schedule;

class ScformController extends Controller
{
    //private $currentScheduleData;
    private $selectedGroupId;

    public function actionIndex()
    {
        $groups = Group::find()->all();
        $displayData = $this->prepareDisplayData([]);
        
        return $this->render('index', [
            'groups' => $groups,
            'displayData' => $displayData,
        ]);
    }

    public function actionSearchSchedule()
    {
        $groupId = Yii::$app->request->post('groups');
        $group = Group::findOne($groupId);

        if ($group !== null) {
            $scheduleData = $this->getScheduleData($group->name);
            $displayData = $this->prepareDisplayData($scheduleData);
            $currentScheduleData = [];

            return $this->render('index', [
                'groups' => Group::find()->all(),
                'displayData' => $displayData,
                'selectedGroup' => $groupId,
                'currentScheduleData' => $scheduleData,
            ]);
        }

        Yii::$app->session->setFlash('error', 'Group not found.');
        return $this->redirect(['index']);
    }

    

    
    
    

    private function getScheduleData($groupName)
{
    $connection = Yii::$app->getDb();
    $command = $connection->createCommand("
        SELECT s.day_of_week, s.lesson, su.subject
        FROM schedule s
        JOIN groups g ON g.id_group = s.id_group
        JOIN curriculum_data cd ON cd.id_of_curriculum_data = s.id_of_curriculum_data
        JOIN subject su ON su.subject_id = cd.subject_id
        WHERE g.name = :groupName
    ");
    $command->bindValue(':groupName', $groupName);
    $scheduleData = $command->queryAll();
    return $scheduleData;
}


    private function prepareDisplayData($scheduleData)
    {
        $displayData = [];
        $daysOfWeek = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];

        for ($lessonNumber = 1; $lessonNumber <= 5; $lessonNumber++) {
            $displayRow = ['lesson' => $lessonNumber];
            foreach ($daysOfWeek as $dayOfWeek) {
                $displayRow[$dayOfWeek] = Html::encode($this->getLessonSubject($dayOfWeek, $lessonNumber, $scheduleData));
            }
            $displayData[] = $displayRow;
        }

        return $displayData;
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

    public function actionSaveSchedule()
{
    $groupId = Yii::$app->request->post('groupId');
    $newScheduleData = Yii::$app->request->post('schedule');
    $currentScheduleData = json_decode(Yii::$app->request->post('currentScheduleData'), true);
    

    $currentScheduleData = $this->getCurrentScheduleData($groupId);

    $newScheduleArray = $this->convertScheduleToArray($newScheduleData);

    if ($this->isScheduleDataChanged($currentScheduleData, $newScheduleArray)) {
        Yii::$app->session->setFlash('success', 'Schedule has been changed.');
        $this->updateScheduleData($groupId, $newScheduleArray); 
    } else {
        Yii::$app->session->setFlash('info', 'Schedule has not been changed.');
    }

    return $this->redirect(['index']);
}

private function getCurrentScheduleData($groupId)
{
    $sessionData = Yii::$app->session->get('currentScheduleData');
    if ($sessionData !== null && $sessionData['groupId'] === $groupId) {
        return $sessionData['scheduleData'];
    }
    return [];
}


    


    
    private function isScheduleDataChanged($currentScheduleData, $newScheduleData)
    {
        $changed = false;
        $length = count($currentScheduleData);
    
        for ($i = 0; $i < $length; $i++) {
            $currentRow = $currentScheduleData[$i];
            $newRow = $newScheduleData[$i];
    
            foreach ($currentRow as $day => $subject) {
                Yii::info("Comparison: Current Schedule[$i][$day] = $subject, New Schedule[$i][$day] = {$newRow[$day]}", 'application');
                if ($newRow[$day] !== $subject) {
                    $changed = true;
                    Yii::info("Comparison: Current Schedule[$i][$day] = $subject, New Schedule[$i][$day] = {$newRow[$day]}", 'application');
                }
            }
        }
    
        Yii::info('Comparison Result: Schedule ' . ($changed ? 'changed' : 'not changed'), 'application');
        return $changed;
    }
    




private function convertScheduleToArray($scheduleData)
{
    $convertedData = [];

    foreach ($scheduleData as $row) {
        $convertedData[] = array_values($row);
    }

    return $convertedData;
}




    
  
private function storeCurrentScheduleData($groupId, $currentScheduleData)
{
    Yii::$app->session->set('currentScheduleData', [
        'groupId' => $groupId,
        'scheduleData' => $currentScheduleData,
    ]);
}

    

    

    
 



    private function updateScheduleData($groupId, $newScheduleData)
{
    
}

}