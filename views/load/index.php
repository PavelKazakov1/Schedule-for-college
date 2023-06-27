


<div class="shadow-overlay"></div>

<div class="intro-content">
    <div class="row">

    <div class="col-twelve form-container" >
    <form method="post">
            <?= yii\helpers\Html::hiddenInput(Yii::$app->request->csrfParam, Yii::$app->request->csrfToken) ?>
            <div class="form-group">
                <label for="year">Year</label>
                <select id="year" name="year">
                    <?php foreach ($years as $yearOption): ?>
                        <option value="<?= $yearOption ?>"><?= $yearOption ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit">Submit</button>
        </form>
        </div>  

        <div class="container">
            <div class="table-container">
                <h1 class="heading">Workload <?= $year ?></h1>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Disciplines</th>
                            <th>Group</th>
                            <th>Weeks</th>
                            <th>Hours per week</th>
                            <th>Total of semester</th>
                        </tr>
                    </thead>
                    <tbody>
                       
                       
                    <?php if (is_iterable($loadData)): ?>
                        <?php foreach ($loadData as $loadItem): ?>
                            <tr>
                                <td data-label="Column_Discipline"><?= $loadItem->subject ?></td>
                                <td data-label="Column_Group"><?= $loadItem->group_name ?></td>
                                <td data-label="Column_Weeks"><?= $loadItem->weeks ?></td>
                                <td data-label="Column_Hoursperweek"><?= $loadItem->hours_per_week ?></td>
                                <td data-label="Column_Total of semester"><?= $loadItem->total_hours ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>


                        <tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>                   
</div>  