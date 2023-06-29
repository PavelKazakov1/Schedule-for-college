<?php

namespace app\controllers;

use yii\web\Controller;
use Yii;
use app\models\Hours;
use app\models\Teacher;

class LoadformController extends Controller
{

    public function actionIndex()
    {
        $teachers = Teacher::find()->all();
        $loadData = [];

        if (Yii::$app->request->isPost) {
            $teacherId = Yii::$app->request->post('teachers');

            $teacher = Teacher::findOne($teacherId);

            if ($teacher !== null) {
                $loadData = $teacher->findLoadDataByTeacherId($teacherId);
            } else {
                Yii::error('Selected teacher not found');
            }
        }

        return $this->render('index', [
            'teachers' => $teachers,
            'loadData' => $loadData,
        ]);
    }





    public function actionSave()
    {
        if (Yii::$app->request->isPost) {
            $postData = Yii::$app->request->post();
            $disciplines = $postData['disciplines'];
            $groups = $postData['groups'];
            $weeks = $postData['weeks'];
            $hoursPerWeek = $postData['hours_per_week'];
            $changesMade = false;
            //var_dump($postData);

            $changesMade = false;
            var_dump($disciplines);
            var_dump($groups);
            var_dump($weeks);
            var_dump($hoursPerWeek);

            foreach ($disciplines as $index => $discipline) {
                $teacherId = $postData['teacherId']; 
                $teacher = Teacher::findOne($teacherId);
    
                if ($teacher !== null) {
                    var_dump($teacher->subject);
                    var_dump($teacher->group_name);
                    var_dump($teacher->weeks);
                    var_dump($teacher->hours_per_week);
                
                    $oldSubject = $teacher->subject;
                    $oldGroup = $teacher->group_name;
                    $oldWeeks = $teacher->weeks;
                    $oldHoursPerWeek = $teacher->hours_per_week;
    
                    $teacher->subject = $discipline;
                    $teacher->group_name = $groups[$index];
                    $teacher->weeks = $weeks[$index];
                    $teacher->hours_per_week = $hoursPerWeek[$index];
    
                    if ($teacher->subject !== $oldSubject ||
                        $teacher->group_name !== $oldGroup ||
                        $teacher->weeks !== $oldWeeks ||
                        $teacher->hours_per_week !== $oldHoursPerWeek) {
                        $changesMade = true; // Changes were made
                    }
    

                    $teacher->save();

                    $loadData = $teacher->findLoadDataByTeacherId($teacherId);

                    $hours = Hours::findOne(['teacher_id' => $teacher->id]);
    
                    if ($hours === null) {
                        
                        $hours = new Hours();
                        $hours->teacher_id = $teacher->id; 
                    }

                    var_dump($changesMade);
                    $hours->type_of_lesson = $postData['type_of_lesson'][$index];
                    $hours->id_of_curriculum_data = $postData['id_of_curriculum_data'][$index];
                    $hours->hours_of_specific_type = $postData['hours_of_specific_type'][$index];
                    $hours->number_of_speciality = $postData['number_of_speciality'][$index];

                    $hours->save();
                } else {
                    Yii::error('Selected teacher not found');
                }
            }

            var_dump($changesMade);
            if ($changesMade) {
                Yii::$app->session->setFlash('success', 'Changes were saved successfully.');
            } else {
                Yii::$app->session->setFlash('info', 'No changes were made.');
            }
        }

        return $this->redirect(['index']); 
    }
    
    

    
    
  
    


}





?>