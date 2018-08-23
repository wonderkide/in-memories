<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\SwitchInput;

/* @var $this yii\web\View */
/* @var $model app\models\VideoModel */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="video-model-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php //echo $form->field($model, 'id_user')->textInput() ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'detail')->textInput(['maxlength' => true]) ?>

    <?php //echo $form->field($model, 'create_date')->textInput() ?>

    <?php //echo $form->field($model, 'update_date')->textInput() ?>

    <?php //echo $form->field($model, 'read')->textInput() ?>

    <?php //echo $form->field($model, 'show')->textInput() ?>

    <?php //echo $form->field($model, 'banned')->textInput() ?>
    
    <?php echo $form->field($model, 'show')->widget(SwitchInput::classname(), []); ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>