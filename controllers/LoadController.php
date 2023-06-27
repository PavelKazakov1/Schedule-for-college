<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Teacher; 
use yii\filters\AccessControl;


class LoadController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['@', 'admin'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {

        

        // Fetch the available years from your data source and assign them to the $years variable
        $years = Yii::$app->db->createCommand('SELECT DISTINCT year FROM curriculum_data')->queryColumn();
    
        // Check if the request is a POST request
        if (Yii::$app->request->isPost) {
            $year = Yii::$app->request->post('year');
            
            // Get the currently logged-in user
            $user = Yii::$app->user->identity;
    
            // Debug: Output the user's ID to verify it
            Yii::info('User ID: ' . $user->id);
           
            // Fetch the teacher model associated with the user
            $teacher = $user->teacher;
            
            if ($teacher !== null) {
                // Teacher is found
                $teacherId = $teacher->id_teacher;
            
                // Call the findLoadData() method of the Teacher model to fetch the load data
                $loadData = Teacher::findLoadData($teacherId, $year);
            } else {
                // Teacher is not found, handle the error accordingly
                $loadData = [];
                Yii::error('Teacher not found for the current user');
            }
            
            return $this->render('index', [
                'year' => $year,
                'loadData' => $loadData,
                'years' => $years, // Pass the $years variable to the view
            ]);
        }
    
        return $this->render('index', [
            'years' => $years, // Pass the $years variable to the view
        ]);
    }
    

}

?>