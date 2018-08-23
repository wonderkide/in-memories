<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\VideoItemModel */

$this->title = 'Update Video Item Model: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Video Item Models', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="video-item-model-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>