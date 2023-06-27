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
                $teacherId = $postData['teacherId']; // Assuming you have a hidden input in your view with the teacher ID
                $teacher = Teacher::findOne($teacherId);
    
                if ($teacher !== null) {
                    var_dump($teacher->subject);
                    var_dump($teacher->group_name);
                    var_dump($teacher->weeks);
                    var_dump($teacher->hours_per_week);
                
                    // Store the current attribute values for comparison
                    $oldSubject = $teacher->subject;
                    $oldGroup = $teacher->group_name;
                    $oldWeeks = $teacher->weeks;
                    $oldHoursPerWeek = $teacher->hours_per_week;
    
                    // Update the teacher's attributes with the submitted form data
                    $teacher->subject = $discipline;
                    $teacher->group_name = $groups[$index];
                    $teacher->weeks = $weeks[$index];
                    $teacher->hours_per_week = $hoursPerWeek[$index];
    
                    // Check if any changes were made
                    if ($teacher->subject !== $oldSubject ||
                        $teacher->group_name !== $oldGroup ||
                        $teacher->weeks !== $oldWeeks ||
                        $teacher->hours_per_week !== $oldHoursPerWeek) {
                        $changesMade = true; // Changes were made
                    }
    
                    // Save the teacher model
                    $teacher->save();
    
                    // Fetch the teacher's load data again
                    $loadData = $teacher->findLoadDataByTeacherId($teacherId);
    
                    // Find the corresponding Hours model by teacher ID
                    $hours = Hours::findOne(['teacher_id' => $teacher->id]);
    
                    if ($hours === null) {
                        // If Hours model doesn't exist, create a new one
                        $hours = new Hours();
                        $hours->teacher_id = $teacher->id; // Assuming there's a 'teacher_id' attribute in the Hours model
                    }

                    var_dump($changesMade);
                    // Update the attributes with the submitted form data
                    $hours->type_of_lesson = $postData['type_of_lesson'][$index];
                    $hours->id_of_curriculum_data = $postData['id_of_curriculum_data'][$index];
                    $hours->hours_of_specific_type = $postData['hours_of_specific_type'][$index];
                    $hours->number_of_speciality = $postData['number_of_speciality'][$index];
    
                    // Save the hours model
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
    
        // Redirect or display success message
        return $this->redirect(['index']); // Redirect to the index page after saving
    }
    
    

    
    
  
    


}





?>