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

        


        $years = Yii::$app->db->createCommand('SELECT DISTINCT year FROM curriculum_data')->queryColumn();

        if (Yii::$app->request->isPost) {
            $year = Yii::$app->request->post('year');
            

            $user = Yii::$app->user->identity;
 
            Yii::info('User ID: ' . $user->id);
           
            $teacher = $user->teacher;
            
            if ($teacher !== null) {
                // Teacher is found
                $teacherId = $teacher->id_teacher;
            
                $loadData = Teacher::findLoadData($teacherId, $year);
            } else {

                $loadData = [];
                Yii::error('Teacher not found for the current user');
            }
            
            return $this->render('index', [
                'year' => $year,
                'loadData' => $loadData,
                'years' => $years, 
            ]);
        }
    
        return $this->render('index', [
            'years' => $years, 
        ]);
    }
    

}

?>