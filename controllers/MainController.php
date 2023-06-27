<?php

namespace app\controllers;

use yii\web\Controller;
use yii\filters\AccessControl;

class MainController extends Controller
{
   

    public function actionIndex()
    {
        return $this->render('index');
    }
}
?>