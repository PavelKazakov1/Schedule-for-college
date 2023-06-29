<?php

namespace app\controllers;

use Yii;
use app\models\User;
use yii\web\Controller;
use yii\filters\AccessControl;

class LoginController extends Controller
{

   
    public function actionIndex()
    {
        $model = new \app\models\LoginForm();

        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->redirect(['load/index']);
        }

        return $this->render('index', [
            'model' => $model,
        ]);
    }
}
