<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\VideoitemSearchModel */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Video Item Models';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="video-item-model-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Video Item Model', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'id_video',
            'title',
            'detail',
            'path',
            // 'thumbnail',
            // 'sorting',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>