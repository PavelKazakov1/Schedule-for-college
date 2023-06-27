<?php
use yii\helpers\Html;
use yii\web\View;

// Register jQuery library
$this->registerJsFile('https://code.jquery.com/jquery-3.6.0.min.js', ['position' => View::POS_HEAD]);

// Register the JavaScript code
$this->registerJs('
$(document).ready(function() {
  // Store the initial schedule data
  var initialScheduleData = JSON.parse($("#initialScheduleData").val());

  // Listen for form submission
  $("form").on("submit", function() {
    // Get the new schedule data
    var newScheduleData = {};

    $("input[name^=\'schedule\']").each(function() {
      var $field = $(this);
      var lesson = $field.data("lesson");
      var day = $field.data("day");
      var value = $field.val();

      if (!newScheduleData.hasOwnProperty(lesson)) {
        newScheduleData[lesson] = {};
      }

      newScheduleData[lesson][day] = value;
    });

    // Compare the initial schedule data with the new schedule data
    var isScheduleDataChanged = issScheduleDataChanged(initialScheduleData, newScheduleData);

    if (isScheduleDataChanged) {
      // Schedule data has changed
      $("#scheduleChangedMessage").text("Schedule data has changed").show();
    } else {
      // Schedule data has not changed
      $("#scheduleChangedMessage").text("Schedule data has not changed").show();
    }
  });

  // Function to compare schedule data
  function isScheduleDataChanged(initialData, newData) {
    // Convert objects to JSON strings for comparison
    var initialDataString = JSON.stringify(initialData);
    var newDataString = JSON.stringify(newData);

    // Compare the JSON strings
    return initialDataString !== newDataString;
  }
});
', View::POS_END);
?>

<form method="post" action="<?= Yii::$app->urlManager->createUrl(['scform/search-schedule']) ?>">
    <?= yii\helpers\Html::hiddenInput(Yii::$app->request->csrfParam, Yii::$app->request->csrfToken) ?>
    <div class="head-container">
        <!--<div class="scform-align">
            <label for="specialties">Specialties:</label>
            <select id="specialties" name="specialties">
                <option value="cs">Computer Science</option>
                <option value="eng">Engineering</option>
                <option value="bus">Business</option>
                <option value="health">Health Sciences</option>
            </select>
        </div>
        -->
        <div class="scform-align">
            <label for="groups">Groups:</label>
            <select id="groups" name="groups">
                <?php foreach ($groups as $group): ?>
                     
                    <option value="<?= $group->id_group ?>" <?= ($selectedGroup == $group->id_group) ? 'selected' : '' ?>><?= $group->name ?></option>
                <?php endforeach; ?>
            </select>

        </div>

        <div class="scform-button">
            <button type="submit" name="search">Search</button>
        </div>
    </div>
</form>

</div>
<div class="alert alert-info" id="scheduleChangedMessage" style="display: none;"></div>

<?php if (Yii::$app->session->hasFlash('success')): ?>
    <div class="alert alert-success">
        <?= Yii::$app->session->getFlash('success') ?>
    </div>
<?php endif; ?>

<?php if (Yii::$app->session->hasFlash('error')): ?>
    <div class="alert alert-danger">
        <?= Yii::$app->session->getFlash('error') ?>
    </div>
<?php endif; ?>

<?php if (Yii::$app->session->hasFlash('info')): ?>
    <div class="alert alert-info">
        <?= Yii::$app->session->getFlash('info') ?>
    </div>
<?php endif; ?>

<div class="center-heading">
    <h1 class="scform-head">Schedule</h1>
</div>

<?php 


?> 
<div class="edit-container">
    <form method="post" action="<?= Yii::$app->urlManager->createUrl(['scform/save-schedule', 'groupId' => $group->id_group]) ?>">
        <?= yii\helpers\Html::hiddenInput(Yii::$app->request->csrfParam, Yii::$app->request->csrfToken) ?>
        <?= yii\helpers\Html::hiddenInput('currentScheduleData', json_encode($currentScheduleData)) ?>
        <?= yii\helpers\Html::hiddenInput('initialScheduleData', json_encode($initialScheduleData), ['id' => 'initialScheduleData']) ?>

        <?php foreach ($displayData as $row): ?>
            <div class="user-details">
                <h1 class="lesson"><?= $row['lesson'] ?></h1>

                <?php $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday']; ?>
                <?php foreach ($days as $day): ?>
                    <div class="input-box">
                        <h1 class="scform-days"><?= $day ?></h1>
                        <input type="hidden" name="initialSchedule[<?= $row['lesson'] ?>][<?= $day ?>]" value="<?= $row[$day] ?>">
                        <input type="text" placeholder="" name="schedule[<?= $row['lesson'] ?>][<?= $day ?>]" value="<?= $row[$day] ?>" data-lesson="<?= $row['lesson'] ?>" data-day="<?= $day ?>">
                    </div>
                <?php endforeach; ?>

                <input type="hidden" name="groupId" value="<?= $group->id_group ?>">
            </div>
        <?php endforeach; ?>

        <div class="scform-submit">
            <button type="submit">Save</button>
        </div>
    </form>
</div>


