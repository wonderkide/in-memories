<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\VideoSearchModel */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Video Models';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="video-model-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Video Model', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'id_user',
            'name',
            'title',
            'detail',
            // 'create_date',
            // 'update_date',
            // 'read',
            // 'show',
            // 'banned',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>