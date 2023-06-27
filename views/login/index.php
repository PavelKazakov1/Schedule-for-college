<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Sign In';
$this->params['breadcrumbs'][] = $this->title;

?>

<body>
    <div class="login">
        <h1>Sign In</h1>
        <?php $form = ActiveForm::begin(['action' => ['login/index']]); ?>
            <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>
            <?= $form->field($model, 'password')->passwordInput() ?>
            <div class="form-group">
                <?= Html::submitButton('Submit', ['class' => 'submit']) ?>
            </div>
        <?php ActiveForm::end(); ?>
        <?php if (Yii::$app->session->hasFlash('error')): ?>
            <div class="alert-danger">
                <?= Yii::$app->session->getFlash('error') ?>
            </div>
        <?php endif; ?>
        <p>If you have any trouble, please contact the administrator.</p>
    </div>
</body>



