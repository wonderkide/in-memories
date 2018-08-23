<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\VideoItemModel */

$this->title = 'Create Video Item Model';
$this->params['breadcrumbs'][] = ['label' => 'Video Item Models', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="video-item-model-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>