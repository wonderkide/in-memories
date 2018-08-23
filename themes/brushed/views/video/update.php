<?php

?>
<?php $this->beginContent('@app/views/layouts/_tab_personal.php', ['active' => 'video']); ?>
    <div class="col-md-4">
        <?= $this->render('_menu') ?>
    </div>
    <div class="col-md-8">
        <div class="memory-model-create">

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">แก้ไขหมวดวีดีโอ</h3>
                </div>
                <div class="panel-body">

                <?= $this->render('_form', [
                    'model' => $model,
                ]) ?>
                </div>
            </div>

        </div>
    </div>
<?php $this->endContent(); ?>