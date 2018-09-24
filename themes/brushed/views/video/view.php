<?php

use app\components\widgets\LikeBox;
use app\components\widgets\commentBox;
use app\components\helpFunction;
use app\models\ContentModel;
use yii\widgets\LinkPager;
use app\assets\PlyrAsset;

PlyrAsset::register($this);
//use app\assets\FPAsset;

//FPAsset::register($this);
?>
<style>
.plyr video{
    max-height:505px;
}
/*
.plyr:-webkit-full-screen video{
    height: 100%;
}*/
.video-wrapper{
    position:relative;
    width:100%;
    overflow:hidden;
}
.video-slider-block{
    height:120px;
    width:100%;
    overflow:hidden;
    margin: 0 auto;
}
.video-slider-block .video-item{
    position:relative;
    width:200px;
    height:120px;
    float:left;
}
.video-slider-block .video-item .video-frame{
    position:absolute;
    width:200px;
    height:120px;
    background: url(<?= Yii::$app->assetManager->getPublishedUrl('@BRUSHAsset') ?>/img/video_frame.png);
    background-repeat: no-repeat;
    background-size: 100% 100%;
}
.video-slider-block .video-item img{
    width:100%;
    height:100%;
}
.video-slider-block .video-item .play-icon{
    position:absolute;
    width:50px;
    top:28%;
    left:38%;
    display:none;
}
.vertical-video .video-slider-block{
    height:100%;
    width:100%;
}
.vertical-video .video-slider-block .video-item{
    width:100%;
    height:90px;
    float:none;
    margin-bottom:13px;
}
/*.vertical-video .video-slider-block .video-item:last-child(1){
    margin-bottom:0;
}*/
.vertical-video .video-slider-block .video-item .video-frame{
    width:100%;
    height:90px;
}
.vertical-video .video-slider-block .video-item .play-icon{
    width:50px;
    top:21%;
    left:35%;
    display:none;
}
#button-slider-top{
    position: absolute;
    top: 1%;
    left: 41.5%;
    width: 31px;
    height: 13px;
    cursor: pointer;
    background: url('<?= Yii::$app->assetManager->getPublishedUrl('@BRUSHAsset') ?>/img/button_hover_slider_hz.png') 0px 0px no-repeat;
}
#button-slider-bottom{
    position: absolute;
    left: 41.5%;
    bottom: 1%;
    width: 31px;
    height: 13px;
    cursor: pointer;
    background: url('<?= Yii::$app->assetManager->getPublishedUrl('@BRUSHAsset') ?>/img/button_hover_slider_hz.png') -31px 0px no-repeat;
}
#button-slider-left{
    position: absolute;
    top: 35%;
    left: 2%;
    width: 13px;
    height: 31px;
    cursor: pointer;
    background: url('<?= Yii::$app->assetManager->getPublishedUrl('@BRUSHAsset') ?>/img/button_hover_slider.png') 0px -31px no-repeat;
}
#button-slider-right{
    position: absolute;
    right: 1%;
    top: 35%;
    width: 13px;
    height: 31px;
    cursor: pointer;
    background: url('<?= Yii::$app->assetManager->getPublishedUrl('@BRUSHAsset') ?>/img/button_hover_slider.png') 0px 0px no-repeat;
}
.video-wrapper .scroll-bar {
    /*width: 100%;*/
    height: 10px;
    border: 0px;
    background: #c3c3c3;
    margin-top:5px;
    margin-bottom:5px;
    /*padding:0 5px;*/
}
.scroll-bar .ui-slider-handle {
    background: #DE5E60;
    border: 0;
}
</style>
<section id="video-view" class="page">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="memory cat-widget">
                    <div class="widget-title">
                                <h4><a href="<?= Yii::$app->seo->getUrl('video') ?>">VIDEO</a></h4>
                                <span class="sub-title"><?= $model->name ?></span>

                                <div class="sep-widget-dou"></div>
                                <div class="clearfix"></div>
                    </div>
                    <div class="widget-content">
                        <?php
                        if($model->banned == 1){ 
                            $content = ContentModel::findOne(['type'=>'alert-banned']);
                        ?>
                            <div class="alert alert-warning text-center" role="alert"><span class="<?= $content->name ?>"></span> <?= $content->content ?> <a href="<?= Yii::$app->seo->getUrl('personal/sent') ?>?to=1">Click!</a></div>
                        <?php } ?>
                            
                            <div class="accordion-inner gallery-detail-header">
                                <div class="row">
                                    <div class="col-md-6 col-sm-6">
                                        <div class="gallery-detail-user">

                                            <label>วีดีโอ : <span><?= $model->name ?></span></label><br>
                                            <label>โดย : <a href="<?= Yii::$app->seo->getUrl('wonder/user') ?>/<?= $user->id ?>"><span><?php if($user->nickname != null){ echo $user->nickname;}else{echo $user->username;} ?></span></a></label><br>
                                            <label>สร้างเมื่อ : <span><?= helpFunction::dateTime($model->create_date) ?></span></label>

                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-6">
                                        <div class="gallery-action likebox">
                                        <?= LikeBox::widget(['model' => $model, 'cat' => 'video', 'position' => 'right']) ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="reply-comment">
                                <?php
                                    echo Yii::$app->controller->renderPartial('_action',['model' => $model]);
                                ?>
                            </div>
                            <div class="accordion-inner">
                                <?php if($items): ?>
                                <div class="gallery-image">
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-10">
                                            <div class="video-player" item="0">
                                                <video id="player"></video>
                                            </div>
                                            <script>
                                                const player = new Plyr('#player');
                                                player.source = {
                                                    type: 'video',
                                                    title: '<?= $items[0]->title ? $items[0]->title :"" ?>',
                                                    sources: [
                                                        {
                                                            src: '<?= $items[0]->path ?>',
                                                            type: 'video/mp4'
                                                        }
                                                    ],
                                                    poster: '<?= $items[0]->thumbnail ? $items[0]->thumbnail:""  ?>'
                                                };
                                                $(document).on('click',  '.change-source', function(){
                                                    var path = $(this).attr('path');
                                                    var thumb = $(this).attr('thumb');
                                                    var title = $(this).attr('title');
                                                    var item = $(this).attr('item');
                                                    player.source = {
                                                        type: 'video',
                                                        title: title,
                                                        sources: [
                                                            {
                                                                src: path,
                                                                type: 'video/mp4'
                                                            }
                                                        ],
                                                        poster: thumb
                                                    };
                                                    player.play();
                                                    $('.video-player').attr('item',item);
                                                    $('.play-icon').hide();
                                                    $(this).find('.play-icon.item-'+item).show();
                                                });
                                                /*player.on('ready', event => {
                                                    const instance = event.detail.plyr;
                                                    console.log(instance);
                                                });*/
                                            </script>
                                        </div>
                                        <div class="col-lg-2 visible-lg vertical-video">
                                            <div class="video-wrapper">
                                                <div class="video-slider-block">
                                                    <?php foreach ($items as $key => $value): ?>
                                                    <div class="video-item" item="<?= $key ?>">
                                                        <a class="change-source" path="<?= $value->path ?>" thumb="<?= $value->thumbnail ? $value->thumbnail:'' ?>" title="<?= $value->title ? $value->title:'' ?>" item="<?= $key ?>">
                                                            <div class="video-frame"></div>
                                                            <img class="img-responsive" src="<?= $value->thumbnail ? $value->thumbnail:'' ?>">
                                                            <div class="play-icon item-<?= $key ?>" style="display: <?= $key == 0 ? 'block' : 'none' ?>"><img class="img-responsive" src="<?= Yii::$app->assetManager->getPublishedUrl('@BRUSHAsset') ?>/img/play_icon.png"></div>
                                                        </a>
                                                    </div>
                                                    <?php endforeach; ?>
                                                    <div class="clearfix"></div>
                                                </div>
                                                <input type="hidden" id="counter-vt" value="0">
                                                <input type="hidden" id="marginnow-vt" value="0">
                                                <input type="hidden" id="status-vt" value="3">
                                                <div id="button-slider-top" increment="2" style="display: none;"></div>
                                                <div id="button-slider-bottom" increment="1" style="display: none;"></div>
                                            </div>
                                            
                                        </div>
                                    </div>
                                </div>
                                <div class="video-wrapper horizontal-video hidden-lg">
                                    <div class="video-slider-block">
                                        <?php foreach ($items as $key => $value): ?>
                                        <div class="video-item" item="<?= $key ?>">
                                            <a class="change-source" path="<?= $value->path ?>" thumb="<?= $value->thumbnail ? $value->thumbnail:'' ?>" title="<?= $value->title ? $value->title:'' ?>" item="<?= $key ?>">
                                                <div class="video-frame"></div>
                                                <img class="img-responsive" src="<?= $value->thumbnail ? $value->thumbnail:'' ?>">
                                                <div class="play-icon item-<?= $key ?>" style="display: <?= $key == 0 ? 'block' : 'none' ?>"><img class="img-responsive" src="<?= Yii::$app->assetManager->getPublishedUrl('@BRUSHAsset') ?>/img/play_icon.png"></div>
                                            </a>
                                        </div>
                                        <?php endforeach; ?>
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="scroll-bar"></div>
                                    <input type="hidden" id="counter" value="0">
                                    <input type="hidden" id="marginnow" value="0">
                                    <input type="hidden" id="status" value="3">
                                    <input type="hidden" id="count-items" value="<?= count($items) ?>">
                                    <div id="button-slider-left" increment="2" style="display: none;"></div>
                                    <div id="button-slider-right" increment="1" style="display: none;"></div>
                                </div>
                                
                                <?php endif; ?>

                            </div>
                            <section class="gallery-comment">
                                <?php 
                                if($comment){
                                    echo commentBox::widget(['model'=>$comment, 'top_model'=>$top_comment, 'pagination'=>$pages->getPage(), 'title'=>$model->name, 'category'=>'video', 'id_category'=>$model->id, '_parent'=>null]);
                                }else{ ?>
                                <?php } ?>
                                <?php
                                // display pagination
                                echo LinkPager::widget([
                                    'pagination' => $pages,
                                ]); ?>

                            </section>
                    </div>
                </div>

            </div>

        </div>
    </div>
</section>
<?php
$js = <<< JS
var video_height = $('.video-player').height();
$('.vertical-video .video-wrapper').css("max-height",video_height+"px");

        
var items = $('#count-items').val();
$(".horizontal-video .video-slider-block").width(items*200);
var video_wrapper = $('.video-wrapper.horizontal-video').width();
var video_block = $(".horizontal-video .video-slider-block").width();
        
if(video_block <= video_wrapper){
    $('.scroll-bar').hide();
}
$(window).on('resize', function(){
    video_wrapper = $('.video-wrapper.horizontal-video').width();
    video_block = $(".horizontal-video .video-slider-block").width();
    if(video_block <= video_wrapper){
        $('.scroll-bar').hide();
    }
    else{
        $('.scroll-bar').show();
    }
});

$(".video-wrapper.horizontal-video").mouseenter(function() {
    if(video_wrapper < video_block){
        showButtonSliderHz();
    }
}).mouseleave(function() {
    hideButtonSliderHz();
});
$(".vertical-video .video-wrapper").mouseenter(function() {
    if(video_wrapper < video_block){
        showButtonSliderVt();
    }
}).mouseleave(function() {
    hideButtonSliderVt();
});
function showButtonSliderHz() {
    $('#button-slider-left').show();
    $('#button-slider-right').show();
}
function hideButtonSliderHz() {
    $('#button-slider-left').hide();
    $('#button-slider-right').hide();
}
function showButtonSliderVt() {
    $('#button-slider-top').show();
    $('#button-slider-bottom').show();
}
function hideButtonSliderVt() {
    $('#button-slider-top').hide();
    $('#button-slider-bottom').hide();
}
        
$(".video-item").mouseenter(function() {
    $(this).find('.play-icon').show();
}).mouseleave(function() {
    if($(this).attr('item') != $(".video-player").attr('item')){
        $(this).find('.play-icon').hide();
    }
});

        
var interv;
$("#counter").val(0);
$("#marginnow").val(0);
$("#status").val(3);
        
$('#button-slider-left').on("click", function(e) {
    increment(2);
});
$('#button-slider-right').on("click", function(e) {
    increment(1);
});
        
function increment(typecount) {
    if ($("#status").val() == 3) {
        $("#status").val(typecount);
        var numli = $('.video-wrapper.horizontal-video').width();
        var allwidth = $(".horizontal-video .video-slider-block").width();
        var posnow = Math.abs($('#marginnow').val());
        if (typecount == 1) {
            var marginlast = posnow + numli;
            if ((marginlast + numli) < allwidth) {
                interv = setInterval(function() {
                    count(typecount, marginlast)
                }, 5);
            } else {
                interv = setInterval(function() {
                    count(typecount, allwidth)
                }, 5);
            }
        } else if (typecount == 2) {
            var marginlast = posnow - numli;
            if (marginlast > 0) {
                interv = setInterval(function() {
                    count(typecount, marginlast)
                }, 5);
            } else {
                interv = setInterval(function() {
                    count(typecount, 0)
                }, 5);
            }
        }
    } else {
        if (typecount == 3) {
            clearInterval(interv)
            $("#status").val(3);
        }
    }
}
function count(intv, marginlast) {
    var d = $("#counter").val();
    var l = $("#marginnow").val();
    if (intv == 1 && d < 100 && (l > marginlast * -1 || l == 0)) {
        var t = ++d;
        $("#counter").val(t);
        $(".ui-slider-handle").css("left", t + "%");
        var margin = Math.round(t / 100 * ($(".video-wrapper.horizontal-video").width() - $(".horizontal-video .video-slider-block").width()));
        $("#marginnow").val(margin);
        $(".horizontal-video .video-slider-block").css("margin-left", margin + "px");
    } else if (intv == 2 && d > 0 && l < marginlast * -1) {
        var t = --d;
        $("#counter").val(t);
        $(".ui-slider-handle").css("left", t + "%");
        var margin = Math.round(t / 100 * ($(".video-wrapper.horizontal-video").width() - $(".horizontal-video .video-slider-block").width()));
        $("#marginnow").val(margin);
        $(".horizontal-video .video-slider-block").css("margin-left", margin + "px");
    } else {
        increment(3);
    }
}

$(".scroll-bar").slider({
    max: 100,
    slide: function( event, ui ) {
        var margin = Math.round( ui.value / 100 * ($(".video-wrapper.horizontal-video").width() - $(".horizontal-video .video-slider-block").width()));
        $(".horizontal-video .video-slider-block").css("margin-left", margin + "px");
        $("#counter").val(ui.value);
        $("#marginnow").val(margin);
    }
});
        
var interv_vt;
$("#counter-vt").val(0);
$("#marginnow-vt").val(0);
$("#status-vt").val(3);
        
$('#button-slider-top').on("click", function(e) {
    incrementVT(2);
        console.log('#button-slider-top');
});
$('#button-slider-bottom').on("click", function(e) {
    incrementVT(1);
});
        
function incrementVT(typecount) {
        console.log(typecount);
    if ($("#status-vt").val() == 3) {
        $("#status-vt").val(typecount);
        var numli = $('.vertical-video .video-wrapper').height();
        var allwidth = $(".vertical-video .video-slider-block").height();
        var posnow = Math.abs($('#marginnow-vt').val());
        if (typecount == 1) {
            var marginlast = posnow + numli;
            if ((marginlast + numli) < allwidth) {
                interv_vt = setInterval(function() {
                    countVT(typecount, marginlast)
                }, 5);
            } else {
                interv_vt = setInterval(function() {
                    countVT(typecount, allwidth)
                }, 5);
            }
        } else if (typecount == 2) {
            var marginlast = posnow - numli;
            if (marginlast > 0) {
                interv_vt = setInterval(function() {
                    countVT(typecount, marginlast)
                }, 5);
            } else {
                interv_vt = setInterval(function() {
                    countVT(typecount, 0)
                }, 5);
            }
        }
    } else {
        if (typecount == 3) {
            clearInterval(interv_vt)
            $("#status-vt").val(3);
        }
    }
}
function countVT(intv, marginlast) {
    var d = $("#counter-vt").val();
    var l = $("#marginnow-vt").val();
    if (intv == 1 && d < 100 && (l > marginlast * -1 || l == 0)) {
        var t = ++d;
        $("#counter-vt").val(t);
        //$(".ui-slider-handle").css("left", t + "%");
        var margin = Math.round(t / 100 * ($(".vertical-video .video-wrapper").height() - $(".vertical-video .video-slider-block").height()));
        $("#marginnow-vt").val(margin);
        $(".vertical-video .video-slider-block").css("margin-top", margin + "px");
    } else if (intv == 2 && d > 0 && l < marginlast * -1) {
        var t = --d;
        $("#counter-vt").val(t);
        //$(".ui-slider-handle").css("left", t + "%");
        var margin = Math.round(t / 100 * ($(".vertical-video .video-wrapper").height() - $(".vertical-video .video-slider-block").height()));
        $("#marginnow-vt").val(margin);
        $(".vertical-video .video-slider-block").css("margin-top", margin + "px");
    } else {
        incrementVT(3);
    }
}
JS;
 
// register your javascript
$this->registerJs($js);