<?php
use yii\bootstrap\Modal;
use yii\helpers\Html;
Modal::begin([
    'header' => null,
    'closeButton' => FALSE,
    //'header' => '<div class="text-center"><label>' . Yii::$app->user->identity->username . '</label></div>',
    'id' => 'user-modal',
    //'htmlOptions' => ['style' => 'width: 200px; height: 300px']
    'size' => Modal::SIZE_SMALL,
    'footer' => Html::a('ข้อมูลส่วนตัว', [Yii::$app->seo->getUrl('personal')], ['class' => 'button button-mini pull-left']).
                Html::a('ออกจากระบบ', [Yii::$app->seo->getUrl('site/logout')], ['class' => 'button button-mini','data-method' => 'post']),
]);
?>
<!-- Modal -->
<div class="text-center header"><label><?= Yii::$app->user->identity->nickname ? Yii::$app->user->identity->nickname : Yii::$app->user->identity->username ?></label></div>
<div class="modal-user-image">
    <?= Html::img(Yii::$app->user->identity->image_crop == '' ? Yii::$app->assetManager->getPublishedUrl('@WDAsset').'/images/df_profile.png':Yii::$app->user->identity->image_crop, ['class' => 'img-responsive']) ?>
</div>
<div class="modal-user-image-button">
    <?php //echo Html::a('อัพโหลดรูป', ['test/wtf', 'id' => 0], ['class' => 'btn btn-default btn-xs']) ?>
</div>
<?php
Modal::end();

$js = <<< JS

$('.modal-user').on('click', function(e){
    $('#user-modal').modal('show');
});
JS;
 
// register your javascript
$this->registerJs($js);