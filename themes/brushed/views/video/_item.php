<?php
use dosamigos\fileupload\FileUploadUI;
?>
<?php $this->beginContent('@app/views/layouts/_tab_personal.php', ['active' => 'video']); ?>
    <div class="col-md-4">
        <?= $this->render('_menu') ?>
    </div>
    <div class="col-md-8">
        <div class="memory-model-create">

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">จัดการ video :: <?= $model->name ?></h3>
                </div>
                <div class="panel-body">

                <?= FileUploadUI::widget([
                    'model' => $model,
                    'attribute' => 'name',
                    'url' => ['media/upload', 'id' => $model->id],
                    'gallery' => false,
                    'fieldOptions' => [
                        'accept' => 'image/*'
                    ],
                    'clientOptions' => [
                        'maxFileSize' => 2000000
                    ],
                    // ...
                    'clientEvents' => [
                        'fileuploaddone' => 'function(e, data) {
                                                console.log(e);
                                                console.log(data);
                                            }',
                        'fileuploadfail' => 'function(e, data) {
                                                console.log(e);
                                                console.log(data);
                                            }',
                    ],
                ]); ?>
                </div>
            </div>

        </div>
    </div>
<?php $this->endContent(); ?>