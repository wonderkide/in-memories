<?php
?>
<style>
    /**************************
*
*	GENERAL
*
**************************/
.camera_wrap a, .camera_wrap img, 
.camera_wrap ol, .camera_wrap ul, .camera_wrap li,
.camera_wrap table, .camera_wrap tbody, .camera_wrap tfoot, .camera_wrap thead, .camera_wrap tr, .camera_wrap th, .camera_wrap td
.camera_thumbs_wrap a, .camera_thumbs_wrap img, 
.camera_thumbs_wrap ol, .camera_thumbs_wrap ul, .camera_thumbs_wrap li,
.camera_thumbs_wrap table, .camera_thumbs_wrap tbody, .camera_thumbs_wrap tfoot, .camera_thumbs_wrap thead, .camera_thumbs_wrap tr, .camera_thumbs_wrap th, .camera_thumbs_wrap td {
	background: none;
	border: 0;
	font: inherit;
	font-size: 100%;
	margin: 0;
	padding: 0;
	vertical-align: baseline;
	list-style: none
}
.camera_wrap {
	display: none;
	float: left;
	position: relative;
	z-index: 0;
}
.camera_wrap img {
	max-width: none!important;
}
.camera_fakehover {
	height: 100%;
	min-height: 60px;
	position: relative;
	width: 100%;
	z-index: 1;
}
.camera_wrap {
	width: 100%;
}
.camera_src {
	display: none;
}
.cameraCont, .cameraContents {
	height: 100%;
	position: relative;
	width: 100%;
	z-index: 1;
}
.cameraSlide {
	bottom: 0;
	left: 0;
	position: absolute;
	right: 0;
	top: 0;
	width: 100%;
}
.cameraContent {
	bottom: 0;
	display: none;
	left: 0;
	position: absolute;
	right: 0;
	top: 0;
	width: 100%;
}
.camera_target {
	bottom: 0;
	height: 100%;
	left: 0;
	overflow: hidden;
	position: absolute;
	right: 0;
	text-align: left;
	top: 0;
	width: 100%;
	z-index: 0;
}
.camera_overlayer {
	bottom: 0;
	height: 100%;
	left: 0;
	overflow: hidden;
	position: absolute;
	right: 0;
	top: 0;
	width: 100%;
	z-index: 0;
}
.camera_target_content {
	bottom: 0;
	left: 0;
	overflow: hidden;
	position: absolute;
	right: 0;
	top: 0;
	z-index: 2;
}
.camera_target_content .camera_link {
    background: url(<?= Yii::$app->assetManager->getPublishedUrl('@WDAsset'); ?>/images/camera/blank.gif);
	display: block;
	height: 100%;
	text-decoration: none;
}
.camera_loader {
    background: #fff url(<?= Yii::$app->assetManager->getPublishedUrl('@WDAsset'); ?>/images/camera/camera-loader.gif) no-repeat center;
	background: rgba(255, 255, 255, 0.9) url(<?= Yii::$app->assetManager->getPublishedUrl('@WDAsset'); ?>/images/camera/camera-loader.gif) no-repeat center;
	border: 1px solid #ffffff;
	-webkit-border-radius: 18px;
	-moz-border-radius: 18px;
	border-radius: 18px;
	height: 36px;
	left: 50%;
	overflow: hidden;
	position: absolute;
	margin: -18px 0 0 -18px;
	top: 50%;
	width: 36px;
	z-index: 3;
}
.camera_bar {
	bottom: 0;
	left: 0;
	overflow: hidden;
	position: absolute;
	right: 0;
	top: 0;
	z-index: 3;
}
.camera_thumbs_wrap.camera_left .camera_bar, .camera_thumbs_wrap.camera_right .camera_bar {
	height: 100%;
	position: absolute;
	width: auto;
}
.camera_thumbs_wrap.camera_bottom .camera_bar, .camera_thumbs_wrap.camera_top .camera_bar {
	height: auto;
	position: absolute;
	width: 100%;
}
.camera_nav_cont {
	height: 65px;
	overflow: hidden;
	position: absolute;
	right: 9px;
	top: 15px;
	width: 120px;
	z-index: 4;
}
.camera_caption {
	bottom: 0;
	display: block;
	position: absolute;
	width: 100%;
}
.camera_caption > div {
	padding: 10px 20px;
}
.camerarelative {
	overflow: hidden;
	position: relative;
}
.imgFake {
	cursor: pointer;
}
.camera_prevThumbs {
	bottom: 4px;
	cursor: pointer;
	left: 0;
	position: absolute;
	top: 4px;
	visibility: hidden;
	width: 30px;
	z-index: 10;
}
.camera_prevThumbs div {
	background: url(<?= Yii::$app->assetManager->getPublishedUrl('@WDAsset'); ?>/images/camera/camera_skins.png) no-repeat -160px 0;
	display: block;
	height: 40px;
	margin-top: -20px;
	position: absolute;
	top: 50%;
	width: 30px;
}
.camera_nextThumbs {
	bottom: 4px;
	cursor: pointer;
	position: absolute;
	right: 0;
	top: 4px;
	visibility: hidden;
	width: 30px;
	z-index: 10;
}
.camera_nextThumbs div {
	background: url(<?= Yii::$app->assetManager->getPublishedUrl('@WDAsset'); ?>/images/camera/camera_skins.png) no-repeat -190px 0;
	display: block;
	height: 40px;
	margin-top: -20px;
	position: absolute;
	top: 50%;
	width: 30px;
}
.camera_command_wrap .hideNav {
	display: none;
}
.camera_command_wrap {
	left: 0;
	position: relative;
	right:0;
	z-index: 4;
}
.camera_wrap .camera_pag .camera_pag_ul {
	list-style: none;
	margin: 0;
	padding: 0;
	text-align: right;
}
.camera_wrap .camera_pag .camera_pag_ul li {
	-webkit-border-radius: 8px;
	-moz-border-radius: 8px;
	border-radius: 8px;
	cursor: pointer;
	display: inline-block;
	height: 16px;
	margin: 20px 5px;
	position: relative;
	text-align: left;
	text-indent: -9999px;
	width: 16px;
}
.camera_commands_emboss .camera_pag .camera_pag_ul li {
	-moz-box-shadow:
		0px 1px 0px rgba(255,255,255,1),
		inset 0px 1px 1px rgba(0,0,0,0.2);
	-webkit-box-shadow:
		0px 1px 0px rgba(255,255,255,1),
		inset 0px 1px 1px rgba(0,0,0,0.2);
	box-shadow:
		0px 1px 0px rgba(255,255,255,1),
		inset 0px 1px 1px rgba(0,0,0,0.2);
}
.camera_wrap .camera_pag .camera_pag_ul li > span {
	-webkit-border-radius: 5px;
	-moz-border-radius: 5px;
	border-radius: 5px;
	height: 8px;
	left: 4px;
	overflow: hidden;
	position: absolute;
	top: 4px;
	width: 8px;
}
.camera_commands_emboss .camera_pag .camera_pag_ul li:hover > span {
	-moz-box-shadow:
		0px 1px 0px rgba(255,255,255,1),
		inset 0px 1px 1px rgba(0,0,0,0.2);
	-webkit-box-shadow:
		0px 1px 0px rgba(255,255,255,1),
		inset 0px 1px 1px rgba(0,0,0,0.2);
	box-shadow:
		0px 1px 0px rgba(255,255,255,1),
		inset 0px 1px 1px rgba(0,0,0,0.2);
}
.camera_wrap .camera_pag .camera_pag_ul li.cameracurrent > span {
	-moz-box-shadow: 0;
	-webkit-box-shadow: 0;
	box-shadow: 0;
}
.camera_pag_ul li img {
	display: none;
	position: absolute;
}
.camera_pag_ul .thumb_arrow {
    border-left: 4px solid transparent;
    border-right: 4px solid transparent;
    border-top: 4px solid;
	top: 0;
	left: 50%;
	margin-left: -4px;
	position: absolute;
}
.camera_prev, .camera_next, .camera_commands {
	cursor: pointer;
	height: 40px;
	margin-top: -20px;
	position: absolute;
	top: 50%;
	width: 40px;
	z-index: 2;
}
.camera_prev {
	left: 0;
}
.camera_prev > span {
	background: url(<?= Yii::$app->assetManager->getPublishedUrl('@WDAsset'); ?>/images/camera/camera_skins.png) no-repeat 0 0;
	display: block;
	height: 40px;
	width: 40px;
}
.camera_next {
	right: 0;
}
.camera_next > span {
	background: url(<?= Yii::$app->assetManager->getPublishedUrl('@WDAsset'); ?>/images/camera/camera_skins.png) no-repeat -40px 0;
	display: block;
	height: 40px;
	width: 40px;
}
.camera_commands {
	right: 41px;
}
.camera_commands > .camera_play {
	background: url(<?= Yii::$app->assetManager->getPublishedUrl('@WDAsset'); ?>/images/camera/camera_skins.png) no-repeat -80px 0;
	height: 40px;
	width: 40px;
}
.camera_commands > .camera_stop {
	background: url(<?= Yii::$app->assetManager->getPublishedUrl('@WDAsset'); ?>/images/camera/camera_skins.png) no-repeat -120px 0;
	display: block;
	height: 40px;
	width: 40px;
}
.camera_wrap .camera_pag .camera_pag_ul li {
	-webkit-border-radius: 8px;
	-moz-border-radius: 8px;
	border-radius: 8px;
	cursor: pointer;
	display: inline-block;
	height: 16px;
	margin: 20px 5px;
	position: relative;
	text-indent: -9999px;
	width: 16px;
}
.camera_thumbs_cont {
	-webkit-border-bottom-right-radius: 4px;
	-webkit-border-bottom-left-radius: 4px;
	-moz-border-radius-bottomright: 4px;
	-moz-border-radius-bottomleft: 4px;
	border-bottom-right-radius: 4px;
	border-bottom-left-radius: 4px;
	overflow: hidden;
	position: relative;
	width: 100%;
}
.camera_commands_emboss .camera_thumbs_cont {
	-moz-box-shadow:
		0px 1px 0px rgba(255,255,255,1),
		inset 0px 1px 1px rgba(0,0,0,0.2);
	-webkit-box-shadow:
		0px 1px 0px rgba(255,255,255,1),
		inset 0px 1px 1px rgba(0,0,0,0.2);
	box-shadow:
		0px 1px 0px rgba(255,255,255,1),
		inset 0px 1px 1px rgba(0,0,0,0.2);
}
.camera_thumbs_cont > div {
	float: left;
	width: 100%;
}
.camera_thumbs_cont ul {
	overflow: hidden;
	padding: 3px 4px 8px;
	position: relative;
	text-align: center;
}
.camera_thumbs_cont ul li {
	display: inline;
	padding: 0 4px;
}
.camera_thumbs_cont ul li > img {
	border: 1px solid;
	cursor: pointer;
	margin-top: 5px;
	vertical-align:bottom;
}
.camera_clear {
	display: block;
	clear: both;
}
.showIt {
	display: none;
}
.camera_clear {
	clear: both;
	display: block;
	height: 1px;
	margin: -1px 0 25px;
	position: relative;
}
/**************************
*
*	COLORS & SKINS
*
**************************/
.pattern_1 .camera_overlayer {
	background: url(<?= Yii::$app->assetManager->getPublishedUrl('@WDAsset'); ?>/images/camera/patterns/overlay1.png) repeat;
}
.pattern_2 .camera_overlayer {
	background: url(<?= Yii::$app->assetManager->getPublishedUrl('@WDAsset'); ?>/images/camera/patterns/overlay2.png) repeat;
}
.pattern_3 .camera_overlayer {
	background: url(<?= Yii::$app->assetManager->getPublishedUrl('@WDAsset'); ?>/images/camera/patterns/overlay3.png) repeat;
}
.pattern_4 .camera_overlayer {
	background: url(<?= Yii::$app->assetManager->getPublishedUrl('@WDAsset'); ?>/images/camera/patterns/overlay4.png) repeat;
}
.pattern_5 .camera_overlayer {
	background: url(<?= Yii::$app->assetManager->getPublishedUrl('@WDAsset'); ?>/images/camera/patterns/overlay5.png) repeat;
}
.pattern_6 .camera_overlayer {
	background: url(<?= Yii::$app->assetManager->getPublishedUrl('@WDAsset'); ?>/images/camera/patterns/overlay6.png) repeat;
}
.pattern_7 .camera_overlayer {
	background: url(<?= Yii::$app->assetManager->getPublishedUrl('@WDAsset'); ?>/images/camera/patterns/overlay7.png) repeat;
}
.pattern_8 .camera_overlayer {
	background: url(<?= Yii::$app->assetManager->getPublishedUrl('@WDAsset'); ?>/images/camera/patterns/overlay8.png) repeat;
}
.pattern_9 .camera_overlayer {
	background: url(<?= Yii::$app->assetManager->getPublishedUrl('@WDAsset'); ?>/images/camera/patterns/overlay9.png) repeat;
}
.pattern_10 .camera_overlayer {
	background: url(<?= Yii::$app->assetManager->getPublishedUrl('@WDAsset'); ?>/images/camera/patterns/overlay10.png) repeat;
}
.camera_caption {
	color: #fff;
}
.camera_caption > div {
	background: #000;
	background: rgba(0, 0, 0, 0.8);
}
.camera_wrap .camera_pag .camera_pag_ul li {
	background: #b7b7b7;
}
.camera_wrap .camera_pag .camera_pag_ul li:hover > span {
	background: #b7b7b7;
}
.camera_wrap .camera_pag .camera_pag_ul li.cameracurrent > span {
	background: #434648;
}
.camera_pag_ul li img {
	border: 4px solid #e6e6e6;
	-moz-box-shadow: 0px 3px 6px rgba(0,0,0,.5);
	-webkit-box-shadow: 0px 3px 6px rgba(0,0,0,.5);
	box-shadow: 0px 3px 6px rgba(0,0,0,.5);
}
.camera_pag_ul .thumb_arrow {
    border-top-color: #e6e6e6;
}
.camera_prevThumbs, .camera_nextThumbs, .camera_prev, .camera_next, .camera_commands, .camera_thumbs_cont {
	background: #d8d8d8;
	background: rgba(216, 216, 216, 0.85);
}
.camera_wrap .camera_pag .camera_pag_ul li {
	background: #b7b7b7;
}
.camera_thumbs_cont ul li > img {
	border-color: 1px solid #000;
}
/*AMBER SKIN*/
.camera_amber_skin .camera_prevThumbs div {
	background-position: -160px -160px;
}
.camera_amber_skin .camera_nextThumbs div {
	background-position: -190px -160px;
}
.camera_amber_skin .camera_prev > span {
	background-position: 0 -160px;
}
.camera_amber_skin .camera_next > span {
	background-position: -40px -160px;
}
.camera_amber_skin .camera_commands > .camera_play {
	background-position: -80px -160px;
}
.camera_amber_skin .camera_commands > .camera_stop {
	background-position: -120px -160px;
}
/*ASH SKIN*/
.camera_ash_skin .camera_prevThumbs div {
	background-position: -160px -200px;
}
.camera_ash_skin .camera_nextThumbs div {
	background-position: -190px -200px;
}
.camera_ash_skin .camera_prev > span {
	background-position: 0 -200px;
}
.camera_ash_skin .camera_next > span {
	background-position: -40px -200px;
}
.camera_ash_skin .camera_commands > .camera_play {
	background-position: -80px -200px;
}
.camera_ash_skin .camera_commands > .camera_stop {
	background-position: -120px -200px;
}
/*AZURE SKIN*/
.camera_azure_skin .camera_prevThumbs div {
	background-position: -160px -240px;
}
.camera_azure_skin .camera_nextThumbs div {
	background-position: -190px -240px;
}
.camera_azure_skin .camera_prev > span {
	background-position: 0 -240px;
}
.camera_azure_skin .camera_next > span {
	background-position: -40px -240px;
}
.camera_azure_skin .camera_commands > .camera_play {
	background-position: -80px -240px;
}
.camera_azure_skin .camera_commands > .camera_stop {
	background-position: -120px -240px;
}
/*BEIGE SKIN*/
.camera_beige_skin .camera_prevThumbs div {
	background-position: -160px -120px;
}
.camera_beige_skin .camera_nextThumbs div {
	background-position: -190px -120px;
}
.camera_beige_skin .camera_prev > span {
	background-position: 0 -120px;
}
.camera_beige_skin .camera_next > span {
	background-position: -40px -120px;
}
.camera_beige_skin .camera_commands > .camera_play {
	background-position: -80px -120px;
}
.camera_beige_skin .camera_commands > .camera_stop {
	background-position: -120px -120px;
}
/*BLACK SKIN*/
.camera_black_skin .camera_prevThumbs div {
	background-position: -160px -40px;
}
.camera_black_skin .camera_nextThumbs div {
	background-position: -190px -40px;
}
.camera_black_skin .camera_prev > span {
	background-position: 0 -40px;
}
.camera_black_skin .camera_next > span {
	background-position: -40px -40px;
}
.camera_black_skin .camera_commands > .camera_play {
	background-position: -80px -40px;
}
.camera_black_skin .camera_commands > .camera_stop {
	background-position: -120px -40px;
}
/*BLUE SKIN*/
.camera_blue_skin .camera_prevThumbs div {
	background-position: -160px -280px;
}
.camera_blue_skin .camera_nextThumbs div {
	background-position: -190px -280px;
}
.camera_blue_skin .camera_prev > span {
	background-position: 0 -280px;
}
.camera_blue_skin .camera_next > span {
	background-position: -40px -280px;
}
.camera_blue_skin .camera_commands > .camera_play {
	background-position: -80px -280px;
}
.camera_blue_skin .camera_commands > .camera_stop {
	background-position: -120px -280px;
}
/*BROWN SKIN*/
.camera_brown_skin .camera_prevThumbs div {
	background-position: -160px -320px;
}
.camera_brown_skin .camera_nextThumbs div {
	background-position: -190px -320px;
}
.camera_brown_skin .camera_prev > span {
	background-position: 0 -320px;
}
.camera_brown_skin .camera_next > span {
	background-position: -40px -320px;
}
.camera_brown_skin .camera_commands > .camera_play {
	background-position: -80px -320px;
}
.camera_brown_skin .camera_commands > .camera_stop {
	background-position: -120px -320px;
}
/*BURGUNDY SKIN*/
.camera_burgundy_skin .camera_prevThumbs div {
	background-position: -160px -360px;
}
.camera_burgundy_skin .camera_nextThumbs div {
	background-position: -190px -360px;
}
.camera_burgundy_skin .camera_prev > span {
	background-position: 0 -360px;
}
.camera_burgundy_skin .camera_next > span {
	background-position: -40px -360px;
}
.camera_burgundy_skin .camera_commands > .camera_play {
	background-position: -80px -360px;
}
.camera_burgundy_skin .camera_commands > .camera_stop {
	background-position: -120px -360px;
}
/*CHARCOAL SKIN*/
.camera_charcoal_skin .camera_prevThumbs div {
	background-position: -160px -400px;
}
.camera_charcoal_skin .camera_nextThumbs div {
	background-position: -190px -400px;
}
.camera_charcoal_skin .camera_prev > span {
	background-position: 0 -400px;
}
.camera_charcoal_skin .camera_next > span {
	background-position: -40px -400px;
}
.camera_charcoal_skin .camera_commands > .camera_play {
	background-position: -80px -400px;
}
.camera_charcoal_skin .camera_commands > .camera_stop {
	background-position: -120px -400px;
}
/*CHOCOLATE SKIN*/
.camera_chocolate_skin .camera_prevThumbs div {
	background-position: -160px -440px;
}
.camera_chocolate_skin .camera_nextThumbs div {
	background-position: -190px -440px;
}
.camera_chocolate_skin .camera_prev > span {
	background-position: 0 -440px;
}
.camera_chocolate_skin .camera_next > span {
	background-position: -40px -440px;
}
.camera_chocolate_skin .camera_commands > .camera_play {
	background-position: -80px -440px;
}
.camera_chocolate_skin .camera_commands > .camera_stop {
	background-position: -120px -440px	;
}
/*COFFEE SKIN*/
.camera_coffee_skin .camera_prevThumbs div {
	background-position: -160px -480px;
}
.camera_coffee_skin .camera_nextThumbs div {
	background-position: -190px -480px;
}
.camera_coffee_skin .camera_prev > span {
	background-position: 0 -480px;
}
.camera_coffee_skin .camera_next > span {
	background-position: -40px -480px;
}
.camera_coffee_skin .camera_commands > .camera_play {
	background-position: -80px -480px;
}
.camera_coffee_skin .camera_commands > .camera_stop {
	background-position: -120px -480px	;
}
/*CYAN SKIN*/
.camera_cyan_skin .camera_prevThumbs div {
	background-position: -160px -520px;
}
.camera_cyan_skin .camera_nextThumbs div {
	background-position: -190px -520px;
}
.camera_cyan_skin .camera_prev > span {
	background-position: 0 -520px;
}
.camera_cyan_skin .camera_next > span {
	background-position: -40px -520px;
}
.camera_cyan_skin .camera_commands > .camera_play {
	background-position: -80px -520px;
}
.camera_cyan_skin .camera_commands > .camera_stop {
	background-position: -120px -520px	;
}
/*FUCHSIA SKIN*/
.camera_fuchsia_skin .camera_prevThumbs div {
	background-position: -160px -560px;
}
.camera_fuchsia_skin .camera_nextThumbs div {
	background-position: -190px -560px;
}
.camera_fuchsia_skin .camera_prev > span {
	background-position: 0 -560px;
}
.camera_fuchsia_skin .camera_next > span {
	background-position: -40px -560px;
}
.camera_fuchsia_skin .camera_commands > .camera_play {
	background-position: -80px -560px;
}
.camera_fuchsia_skin .camera_commands > .camera_stop {
	background-position: -120px -560px	;
}
/*GOLD SKIN*/
.camera_gold_skin .camera_prevThumbs div {
	background-position: -160px -600px;
}
.camera_gold_skin .camera_nextThumbs div {
	background-position: -190px -600px;
}
.camera_gold_skin .camera_prev > span {
	background-position: 0 -600px;
}
.camera_gold_skin .camera_next > span {
	background-position: -40px -600px;
}
.camera_gold_skin .camera_commands > .camera_play {
	background-position: -80px -600px;
}
.camera_gold_skin .camera_commands > .camera_stop {
	background-position: -120px -600px	;
}
/*GREEN SKIN*/
.camera_green_skin .camera_prevThumbs div {
	background-position: -160px -640px;
}
.camera_green_skin .camera_nextThumbs div {
	background-position: -190px -640px;
}
.camera_green_skin .camera_prev > span {
	background-position: 0 -640px;
}
.camera_green_skin .camera_next > span {
	background-position: -40px -640px;
}
.camera_green_skin .camera_commands > .camera_play {
	background-position: -80px -640px;
}
.camera_green_skin .camera_commands > .camera_stop {
	background-position: -120px -640px	;
}
/*GREY SKIN*/
.camera_grey_skin .camera_prevThumbs div {
	background-position: -160px -680px;
}
.camera_grey_skin .camera_nextThumbs div {
	background-position: -190px -680px;
}
.camera_grey_skin .camera_prev > span {
	background-position: 0 -680px;
}
.camera_grey_skin .camera_next > span {
	background-position: -40px -680px;
}
.camera_grey_skin .camera_commands > .camera_play {
	background-position: -80px -680px;
}
.camera_grey_skin .camera_commands > .camera_stop {
	background-position: -120px -680px	;
}
/*INDIGO SKIN*/
.camera_indigo_skin .camera_prevThumbs div {
	background-position: -160px -720px;
}
.camera_indigo_skin .camera_nextThumbs div {
	background-position: -190px -720px;
}
.camera_indigo_skin .camera_prev > span {
	background-position: 0 -720px;
}
.camera_indigo_skin .camera_next > span {
	background-position: -40px -720px;
}
.camera_indigo_skin .camera_commands > .camera_play {
	background-position: -80px -720px;
}
.camera_indigo_skin .camera_commands > .camera_stop {
	background-position: -120px -720px	;
}
/*KHAKI SKIN*/
.camera_khaki_skin .camera_prevThumbs div {
	background-position: -160px -760px;
}
.camera_khaki_skin .camera_nextThumbs div {
	background-position: -190px -760px;
}
.camera_khaki_skin .camera_prev > span {
	background-position: 0 -760px;
}
.camera_khaki_skin .camera_next > span {
	background-position: -40px -760px;
}
.camera_khaki_skin .camera_commands > .camera_play {
	background-position: -80px -760px;
}
.camera_khaki_skin .camera_commands > .camera_stop {
	background-position: -120px -760px	;
}
/*LIME SKIN*/
.camera_lime_skin .camera_prevThumbs div {
	background-position: -160px -800px;
}
.camera_lime_skin .camera_nextThumbs div {
	background-position: -190px -800px;
}
.camera_lime_skin .camera_prev > span {
	background-position: 0 -800px;
}
.camera_lime_skin .camera_next > span {
	background-position: -40px -800px;
}
.camera_lime_skin .camera_commands > .camera_play {
	background-position: -80px -800px;
}
.camera_lime_skin .camera_commands > .camera_stop {
	background-position: -120px -800px	;
}
/*MAGENTA SKIN*/
.camera_magenta_skin .camera_prevThumbs div {
	background-position: -160px -840px;
}
.camera_magenta_skin .camera_nextThumbs div {
	background-position: -190px -840px;
}
.camera_magenta_skin .camera_prev > span {
	background-position: 0 -840px;
}
.camera_magenta_skin .camera_next > span {
	background-position: -40px -840px;
}
.camera_magenta_skin .camera_commands > .camera_play {
	background-position: -80px -840px;
}
.camera_magenta_skin .camera_commands > .camera_stop {
	background-position: -120px -840px	;
}
/*MAROON SKIN*/
.camera_maroon_skin .camera_prevThumbs div {
	background-position: -160px -880px;
}
.camera_maroon_skin .camera_nextThumbs div {
	background-position: -190px -880px;
}
.camera_maroon_skin .camera_prev > span {
	background-position: 0 -880px;
}
.camera_maroon_skin .camera_next > span {
	background-position: -40px -880px;
}
.camera_maroon_skin .camera_commands > .camera_play {
	background-position: -80px -880px;
}
.camera_maroon_skin .camera_commands > .camera_stop {
	background-position: -120px -880px	;
}
/*ORANGE SKIN*/
.camera_orange_skin .camera_prevThumbs div {
	background-position: -160px -920px;
}
.camera_orange_skin .camera_nextThumbs div {
	background-position: -190px -920px;
}
.camera_orange_skin .camera_prev > span {
	background-position: 0 -920px;
}
.camera_orange_skin .camera_next > span {
	background-position: -40px -920px;
}
.camera_orange_skin .camera_commands > .camera_play {
	background-position: -80px -920px;
}
.camera_orange_skin .camera_commands > .camera_stop {
	background-position: -120px -920px	;
}
/*OLIVE SKIN*/
.camera_olive_skin .camera_prevThumbs div {
	background-position: -160px -1080px;
}
.camera_olive_skin .camera_nextThumbs div {
	background-position: -190px -1080px;
}
.camera_olive_skin .camera_prev > span {
	background-position: 0 -1080px;
}
.camera_olive_skin .camera_next > span {
	background-position: -40px -1080px;
}
.camera_olive_skin .camera_commands > .camera_play {
	background-position: -80px -1080px;
}
.camera_olive_skin .camera_commands > .camera_stop {
	background-position: -120px -1080px	;
}
/*PINK SKIN*/
.camera_pink_skin .camera_prevThumbs div {
	background-position: -160px -960px;
}
.camera_pink_skin .camera_nextThumbs div {
	background-position: -190px -960px;
}
.camera_pink_skin .camera_prev > span {
	background-position: 0 -960px;
}
.camera_pink_skin .camera_next > span {
	background-position: -40px -960px;
}
.camera_pink_skin .camera_commands > .camera_play {
	background-position: -80px -960px;
}
.camera_pink_skin .camera_commands > .camera_stop {
	background-position: -120px -960px	;
}
/*PISTACHIO SKIN*/
.camera_pistachio_skin .camera_prevThumbs div {
	background-position: -160px -1040px;
}
.camera_pistachio_skin .camera_nextThumbs div {
	background-position: -190px -1040px;
}
.camera_pistachio_skin .camera_prev > span {
	background-position: 0 -1040px;
}
.camera_pistachio_skin .camera_next > span {
	background-position: -40px -1040px;
}
.camera_pistachio_skin .camera_commands > .camera_play {
	background-position: -80px -1040px;
}
.camera_pistachio_skin .camera_commands > .camera_stop {
	background-position: -120px -1040px	;
}
/*PINK SKIN*/
.camera_pink_skin .camera_prevThumbs div {
	background-position: -160px -80px;
}
.camera_pink_skin .camera_nextThumbs div {
	background-position: -190px -80px;
}
.camera_pink_skin .camera_prev > span {
	background-position: 0 -80px;
}
.camera_pink_skin .camera_next > span {
	background-position: -40px -80px;
}
.camera_pink_skin .camera_commands > .camera_play {
	background-position: -80px -80px;
}
.camera_pink_skin .camera_commands > .camera_stop {
	background-position: -120px -80px;
}
/*RED SKIN*/
.camera_red_skin .camera_prevThumbs div {
	background-position: -160px -1000px;
}
.camera_red_skin .camera_nextThumbs div {
	background-position: -190px -1000px;
}
.camera_red_skin .camera_prev > span {
	background-position: 0 -1000px;
}
.camera_red_skin .camera_next > span {
	background-position: -40px -1000px;
}
.camera_red_skin .camera_commands > .camera_play {
	background-position: -80px -1000px;
}
.camera_red_skin .camera_commands > .camera_stop {
	background-position: -120px -1000px	;
}
/*TANGERINE SKIN*/
.camera_tangerine_skin .camera_prevThumbs div {
	background-position: -160px -1120px;
}
.camera_tangerine_skin .camera_nextThumbs div {
	background-position: -190px -1120px;
}
.camera_tangerine_skin .camera_prev > span {
	background-position: 0 -1120px;
}
.camera_tangerine_skin .camera_next > span {
	background-position: -40px -1120px;
}
.camera_tangerine_skin .camera_commands > .camera_play {
	background-position: -80px -1120px;
}
.camera_tangerine_skin .camera_commands > .camera_stop {
	background-position: -120px -1120px	;
}
/*TURQUOISE SKIN*/
.camera_turquoise_skin .camera_prevThumbs div {
	background-position: -160px -1160px;
}
.camera_turquoise_skin .camera_nextThumbs div {
	background-position: -190px -1160px;
}
.camera_turquoise_skin .camera_prev > span {
	background-position: 0 -1160px;
}
.camera_turquoise_skin .camera_next > span {
	background-position: -40px -1160px;
}
.camera_turquoise_skin .camera_commands > .camera_play {
	background-position: -80px -1160px;
}
.camera_turquoise_skin .camera_commands > .camera_stop {
	background-position: -120px -1160px	;
}
/*VIOLET SKIN*/
.camera_violet_skin .camera_prevThumbs div {
	background-position: -160px -1200px;
}
.camera_violet_skin .camera_nextThumbs div {
	background-position: -190px -1200px;
}
.camera_violet_skin .camera_prev > span {
	background-position: 0 -1200px;
}
.camera_violet_skin .camera_next > span {
	background-position: -40px -1200px;
}
.camera_violet_skin .camera_commands > .camera_play {
	background-position: -80px -1200px;
}
.camera_violet_skin .camera_commands > .camera_stop {
	background-position: -120px -1200px	;
}
/*WHITE SKIN*/
.camera_white_skin .camera_prevThumbs div {
	background-position: -160px -80px;
}
.camera_white_skin .camera_nextThumbs div {
	background-position: -190px -80px;
}
.camera_white_skin .camera_prev > span {
	background-position: 0 -80px;
}
.camera_white_skin .camera_next > span {
	background-position: -40px -80px;
}
.camera_white_skin .camera_commands > .camera_play {
	background-position: -80px -80px;
}
.camera_white_skin .camera_commands > .camera_stop {
	background-position: -120px -80px;
}
/*YELLOW SKIN*/
.camera_yellow_skin .camera_prevThumbs div {
	background-position: -160px -1240px;
}
.camera_yellow_skin .camera_nextThumbs div {
	background-position: -190px -1240px;
}
.camera_yellow_skin .camera_prev > span {
	background-position: 0 -1240px;
}
.camera_yellow_skin .camera_next > span {
	background-position: -40px -1240px;
}
.camera_yellow_skin .camera_commands > .camera_play {
	background-position: -80px -1240px;
}
.camera_yellow_skin .camera_commands > .camera_stop {
	background-position: -120px -1240px	;
}

</style>
<script>
		jQuery(function(){
			
			jQuery('#camera_wrap_1').camera({
                            pagination: false,
                            thumbnails: true,
                            //overlayer: false,
                            hover: false,
                            //playPause: false,
                            //barPosition: 'top',
                            //height: '50%',
                            time: 3000
			});
		});
	</script>
    
	<div class="fluid_container">
    	<p>Pagination circles with the height relative to the width</p>
        <div class="camera_wrap camera_maroon_skin" id="camera_wrap_1">
            <div data-thumb="<?= Yii::$app->homeUrl ?>uploads/img/review/alila/thumb-01.jpg" data-src="<?= Yii::$app->homeUrl ?>uploads/img/review/alila/01.jpg">
                <div class="camera_caption fadeFromBottom">
                    Camera is a responsive/adaptive slideshow. <em>Try to resize the browser window</em>
                </div>
            </div>
            <div data-thumb="<?= Yii::$app->homeUrl ?>uploads/img/review/alila/thumb-02.jpg" data-src="<?= Yii::$app->homeUrl ?>uploads/img/review/alila/02.jpg">
                <div class="camera_caption fadeFromBottom">
                    It uses a light version of jQuery mobile, <em>navigate the slides by swiping with your fingers</em>
                </div>
            </div>
            <div data-thumb="<?= Yii::$app->homeUrl ?>uploads/img/review/alila/thumb-03.jpg" data-src="<?= Yii::$app->homeUrl ?>uploads/img/review/alila/03.jpg">
                <div class="camera_caption fadeFromBottom">
                    <em>It's completely free</em> (even if a donation is appreciated)
                </div>
            </div>
            <div data-thumb="<?= Yii::$app->homeUrl ?>uploads/img/review/alila/thumb-04.jpg" data-src="<?= Yii::$app->homeUrl ?>uploads/img/review/alila/04.jpg">
                <div class="camera_caption fadeFromBottom">
                    Camera slideshow provides many options <em>to customize your project</em> as more as possible
                </div>
            </div>
            <div data-thumb="<?= Yii::$app->homeUrl ?>uploads/img/review/alila/thumb-05.jpg" data-src="<?= Yii::$app->homeUrl ?>uploads/img/review/alila/05.jpg">
                <div class="camera_caption fadeFromBottom">
                    It supports captions, HTML elements and videos and <em>it's validated in HTML5</em> (<a href="http://validator.w3.org/check?uri=http%3A%2F%2Fwww.pixedelic.com%2Fplugins%2Fcamera%2F&amp;charset=%28detect+automatically%29&amp;doctype=Inline&amp;group=0&amp;user-agent=W3C_Validator%2F1.2" target="_blank">have a look</a>)
                </div>
            </div>
            <div data-thumb="<?= Yii::$app->homeUrl ?>uploads/img/review/alila/thumb-06.jpg" data-src="<?= Yii::$app->homeUrl ?>uploads/img/review/alila/06.jpg">
                <div class="camera_caption fadeFromBottom">
                    Different color skins and layouts available, <em>fullscreen ready too</em>
                </div>
            </div>
        </div><!-- #camera_wrap_1 -->
    </div><!-- .fluid_container -->
    
    <div style="clear:both; display:block; height:100px"></div>