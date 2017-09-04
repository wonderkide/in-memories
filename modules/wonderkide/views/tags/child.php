<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\TagsSearchModel */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'จัดการ Tag '.$id->name_th;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tags-model-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('เพิ่ม Tags', [Url::to('/wonderkide/tags/createchild/'.$id->id_tag)], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id_tags',
            'name_th',
            'name_en',
            'category',
            //'group',
            // 'parent_id',
            [
                        'class' => 'yii\grid\DataColumn',
                        'attribute' => 'group',
                        'format' => 'text',
                        'value' => function ($data) {
                            return Yii::$app->params['tagGroup'][$data->group];
                        },
            ],

            //['class' => 'yii\grid\ActionColumn'],
            ['class' => 'yii\grid\ActionColumn',
                        'template' => '{update} {delete}',
                        /*'buttons' => [
                            'child' => function ($url, $model) {
                                return Html::a('<span class="glyphicon glyphicon-list"></span>', '/wonderkide/tags/child/' . $model->id_tag, [ 'title' => Yii::t('app', 'Child tag')]);
                            },
                        ]*/
            ],
        ],
    ]); ?>

</div>