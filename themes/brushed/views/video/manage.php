<?php
use yii\helpers\Html;
use yii\grid\GridView;
?>
<?php $this->beginContent('@app/views/layouts/_tab_personal.php', ['active' => 'video']); ?>
    <div class="col-md-4">
        <?= $this->render('_menu') ?>
    </div>
    <div class="col-md-8">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">จัดการ video</h3>
            </div>
            <div class="panel-body">
                <div class="video-model-index">

                    <p>
                        <?= Html::a('เพิ่มหมวด Video', ['create'], ['class' => 'btn btn-success']) ?>
                    </p>
                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],

                            //'id',
                            //'id_user',
                            'name',
                            'title',
                            'detail',
                            // 'create_date',
                            // 'update_date',
                            // 'read',
                            // 'show',
                            // 'banned',

                            //['class' => 'yii\grid\ActionColumn'],
                            ['class' => 'yii\grid\ActionColumn',
                                'template' => '{add} {update} {delete}',
                                'buttons' => [
                                    /*'update' => function ($url, $model) {
                                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>', '/personal/edit_pm/' . $model->id);
                                    },*/
                                    'add' => function ($url, $model) {
                                        return Html::a('<span class="glyphicon glyphicon-plus"></span>', '/video/item/'.$model->id, ['class'=>'del-pm-message', 'data-selected'=>$model->id]);
                                    },
                                ]
                            ],
                        ],
                    ]); ?>
                </div>
            </div>
        </div>
    </div>
<?php $this->endContent(); ?>
