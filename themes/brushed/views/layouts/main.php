<?php
use yii\helpers\Html;
use app\assets\BRUSHAsset;
use app\assets\importWDAsset;
use app\models\MainDataModel;
use app\models\GalleryModel;
use app\models\GalleryImagesModel;
use app\models\SettingModel;
use app\components\widgets\mainMenuBrush;
use app\components\widgets\notifyDropdown;
use app\components\widgets\AlertNotify;
rmrevin\yii\fontawesome\AssetBundle::register($this);

importWDAsset::register($this);
BRUSHAsset::register($this);


?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<!--[if lt IE 7]><html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if (IE 7)&!(IEMobile)]><html class="no-js lt-ie9 lt-ie8" lang="en"><![endif]-->
<!--[if (IE 8)&!(IEMobile)]><html class="no-js lt-ie9" lang="en"><![endif]-->
<!--[if (IE 9)]><html class="no-js ie9" lang="en"><![endif]-->
<!--[if gt IE 8]><!--> <html lang="<?= Yii::$app->language ?>"> <!--<![endif]-->
<head>

<!-- Meta Tags -->
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

<!-- Mobile Specifics -->
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="HandheldFriendly" content="true"/>
<meta name="MobileOptimized" content="320"/>  

<?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
<?php $this->head() ?>
 

<!-- Mobile Internet Explorer ClearType Technology -->
<!--[if IEMobile]>  <meta http-equiv="cleartype" content="on">  <![endif]-->

<!-- Google Font -->
<link href='http://fonts.googleapis.com/css?family=Titillium+Web:400,200,200italic,300,300italic,400italic,600,600italic,700,700italic,900' rel='stylesheet' type='text/css'>

<!-- Fav Icon -->
<link rel="shortcut icon" href="<?= MainDataModel::getIcon(); ?>" type="image/x-icon">

<link rel="apple-touch-icon" href="#">
<link rel="apple-touch-icon" sizes="114x114" href="#">
<link rel="apple-touch-icon" sizes="72x72" href="#">
<link rel="apple-touch-icon" sizes="144x144" href="#">

</head>


<body>
<?php $this->beginBody() ?>
<!-- This section is for Splash Screen -->
<div class="ole">
<section id="jSplash">
	<div id="circle"></div>
</section>
</div>
<!-- End of Splash Screen -->

<?php
if(SettingModel::checkSetting("home_slider")){
    $model = GalleryModel::topGallery();
?>
<!-- Homepage Slider -->
<div id="home-slider">	
    <div class="overlay"></div>

    <div class="slider-text">
    	<div id="slidecaption"></div>
    </div>   
	
	<div class="control-nav">
        <a id="prevslide" class="load-item"><i class="font-icon-arrow-simple-left"></i></a>
        <a id="nextslide" class="load-item"><i class="font-icon-arrow-simple-right"></i></a>
        <ul id="slide-list"></ul>
        
        <a id="nextsection" href="#main-content-box"><i class="font-icon-arrow-simple-down"></i></a>
    </div>
    <?php
    if($model){
        foreach ($model as $key => $row) {
            $ran = array_rand(Yii::$app->params['animate'],1);
            $selected = Yii::$app->params['animate'][$ran];
            $animate = 'animated ' . $selected;
    ?>
    <div id="slide-img-<?= $key+1 ?>" class="hidden" img="<?= GalleryImagesModel::getImageFullFirst($row->id) ?>" name="<?= $row->name ?>" animate="<?= $animate ?>" href="/gallery/view/<?= $row->ref ?>"></div>
    <?php
    }}
    ?>
</div>
<!-- End Homepage Slider -->
<?php
}
?>

<!-- Header -->
<header id="nav-main-menu">
    <div class="sticky-nav">
    	<a id="mobile-nav" class="menu-nav" href="#menu-nav"></a>
        
        <div id="logo">
        	<a id="goUp" href="/" title="Brushed | Responsive One Page Template"><?= MainDataModel::getLogo(); ?></a>
        </div>
        
        <nav id="menu">
            <ul id="menu-nav">
            	<?= mainMenuBrush::widget(); ?>
            </ul>
        </nav>
        <?= notifyDropdown::widget(['limit' => 5]); ?>
        
    </div>
</header>
<!-- End Header -->
<div id="main-content-box">
    <?= $content ?>
</div>
<?php
if(Yii::$app->user->isGuest){
    echo $this->render('_sign_modal');
}
else{
    echo $this->render('_user_modal');
    echo AlertNotify::widget();
}
?>

<!-- Footer -->
<footer>
	<p class="credits">&copy;2017 in-momories.com ALL RIGHTS RESERVED.</p>
</footer>
<!-- End Footer -->

<!-- Back To Top -->
<a id="back-to-top" href="#">
    <i class="font-icon-arrow-simple-up"></i>
</a>
<!-- End Back to Top -->

<!-- notification show after update caption -->
<div id="notify-access-caption" class="notify-access-caption">
    <div class="box-content">
        <label id="icon-notify"></label>
        <label class="glyphicon glyphicon-remove close-notify"></label>
        <label class="title">title</label>
        <hr class="separeter">
        <p class="content">content</p>
    </div>
</div>


<input type="hidden" id="assets-path" value="<?= Yii::$app->assetManager->getPublishedUrl('@BRUSHAsset') ?>">
<?php Yii::$app->facebook->loadChatBox(); ?>
<?php Yii::$app->facebook->loadScript(); ?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>