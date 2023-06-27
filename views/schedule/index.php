<?php

use app\models\Schedule;
use yii\helpers\Html;

//var_dump($scheduleData);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>

<div class="shadow-overlay"></div>

<div class="intro-content"> 
    <div class="col-twelve form-container">
        <form action="<?= Yii::$app->urlManager->createUrl(['schedule/index']) ?>" method="POST">
           
            <div class="form-group">
                <label for="groups">Groups:</label>
                <select id="groups" name="groups">
                    <?php foreach ($groups as $group): ?>
                        <option value="<?= Html::encode($group->name) ?>"><?= Html::encode($group->name) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <?= Html::hiddenInput(Yii::$app->request->csrfParam, Yii::$app->request->csrfToken) ?>

            <button type="submit">Submit</button>
        </form>
    </div>  

    <div class="container">
        <div class="table-container">
            <h1 class="heading">Schedule</h1>
            <table class="table">
                <thead>
                    <tr>
                        <th>Lesson/Day</th>
                        <th>Monday</th>
                        <th>Tuesday</th>
                        <th>Wednesday</th>
                        <th>Thursday</th>
                        <th>Friday</th>
                        <th>Saturday</th>
                    </tr>
                </thead>
                <tbody>

                  
                    <?php foreach ($displayData as $row): ?>
                        <tr>
                            <td><?= $row['lesson'] ?> Lesson</td>
                            <td><?= $row['Monday'] ?></td>
                            <td><?= $row['Tuesday'] ?></td>
                            <td><?= $row['Wednesday'] ?></td>
                            <td><?= $row['Thursday'] ?></td>
                            <td><?= $row['Friday'] ?></td>
                            <td><?= $row['Saturday'] ?></td>
                        </tr>
                    <?php endforeach; ?>

                </tbody>
            </table>
        </div>
    </div>
</div>
