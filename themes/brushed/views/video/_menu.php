<?php
use yii\helpers\Url;
use kartik\widgets\SideNav;
use app\components\MyController;
use app\components\widgets\updateZeny;

//add personal css file
$this->registerCssFile(Yii::$app->assetManager->getPublishedUrl('@WDAsset')."/css/personal.css", [
    'depends' => ['yii\web\YiiAsset','yii\bootstrap\BootstrapAsset'],
]);
$this->registerJsFile(Yii::$app->assetManager->getPublishedUrl('@WDAsset')."/js/personal.js", ['depends' => [\yii\web\JqueryAsset::className()]]);

$type = SideNav::TYPE_INFO;
$heading = '<i class="glyphicon glyphicon-cog"></i> Personal';

$item = Yii::$app->urlManager->parseRequest(Yii::$app->request)[0];

$menu = [];

//video
array_push($menu, ['label' => 'Video', 'icon' => 'picture', 'items' => [
        ['label' => 'จัดการ video <i class="fa fa-pencil-square-o fa-lg" aria-hidden="true"></i>', 'url' => Url::to([Yii::$app->seo->getUrl('video/manage')]), 'active' => ($item =='video/manage' || $item =='video/index') ],
        ['label' => 'เพิ่มหมวด <i class="fa fa-file-image-o fa-lg" aria-hidden="true"></i>', 'url' => Url::to([Yii::$app->seo->getUrl('video/create')]), 'active' => ($item =='video/create')],
            
        ]]);

echo SideNav::widget([
    'type' => $type,
    'encodeLabels' => false,
    //'heading' => $heading,
    'items' => $menu
]);
?>

<section id="update-zeny">
    <?= updateZeny::widget(); ?>
</section>