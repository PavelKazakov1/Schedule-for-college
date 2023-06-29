<?php
use app\models\Speciality;
use app\models\Group;
use yii\helpers\Html;
?>


<div class="head-container">
   

    <div class="scform-align">
        <form action="<?= Yii::$app->getUrlManager()->createUrl(['loadform/index']) ?>" method="post">
            <label for="teachers">Teacher</label>
            <select id="teachers" name="teachers">
                <?php foreach ($teachers as $teacher): ?>
                    <option value="<?= Html::encode($teacher->id_teacher) ?>">
                        <?= Html::encode($teacher->name) ?> <?= Html::encode($teacher->surname) ?> <?= Html::encode($teacher->patronymic) ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <input type="hidden" name="_csrf" value="<?= Yii::$app->request->getCsrfToken() ?>" />
            <button type="submit">Search</button>
        </form>
    </div>
</div>
                   
</div>
<?php
//$specialities = Speciality::find()->all();
//$groups = Group::find()->all();
//var_dump(is_array($specialities));
//var_dump(is_array($groups));
?>
<div class="center-heading">
    <h1 class="scform-head">Load Edition</h1>
</div>

<?php if (Yii::$app->session->hasFlash('success')): ?>
    <div class="alert alert-success">
        <?= Yii::$app->session->getFlash('success') ?>
    </div>
<?php elseif (Yii::$app->session->hasFlash('info')): ?>
    <div class="alert alert-info">
        <?= Yii::$app->session->getFlash('info') ?>
    </div>
<?php endif; ?>

 <div class="edit-container">

 <form action="<?= Yii::$app->getUrlManager()->createUrl(['loadform/save']) ?>" method="post">
 <?= Html::hiddenInput(Yii::$app->request->csrfParam, Yii::$app->request->csrfToken) ?>
<div class="user-details">

<?php foreach ($loadData as $index => $loadItem): ?>
    <div class="input-box">
        <h1 class="scform-days">Disciplines</h1>
        <input type="text" name="disciplines[]" value="<?= Html::encode($loadItem->subject) ?>" required>
    </div>
    <div class="input-box">
        <h1 class="scform-days">Group</h1>
        <input type="text" name="groups[]" value="<?= Html::encode($loadItem->group_name) ?>" required>
    </div>
    <input type="hidden" name="teacherId" value="<?= Html::encode($loadItem->id_teacher) ?>">
    <div class="input-box">
        <h1 class="scform-days">Weeks</h1>
        <input type="text" name="weeks[]" value="<?= Html::encode($loadItem->weeks) ?>" required>
    </div>
    <div class="input-box">
        <h1 class="scform-days">Hours per week</h1>
        <input type="text" name="hours_per_week[]" value="<?= Html::encode($loadItem->hours_per_week) ?>" required>
    </div>
    <div class="input-box">
        <h1 class="scform-days">Total of semester</h1>
        <span class="total-semester">
            <span class="total-semester-number"><?= Html::encode($loadItem->total_of_semester) ?></span>
        </span>
    </div>
<?php endforeach; ?>

</div>
            
    <div class="scform-submit">
    <button type="submit" >Save</button>
    </div>
        
    </form>
</div>