<?php

use app\components\widgets\LikeBox;
use app\components\widgets\commentBox;
use app\components\helpFunction;
use app\models\ContentModel;
use yii\widgets\LinkPager;
use app\assets\FPAsset;

FPAsset::register($this);
?>

<section id="video-view" class="page">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="memory cat-widget animated fadeInRight">
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
                                <?php 
                                $playlist = "";
                                foreach ($items as $key => $value) {
                                    $playlist .= '{sources: [{ type: "video/mp4", src:  "'.$value->path.'" }]},';
                                }
                                ?>
                                <div class="video-image animated bounceInLeft">
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-10">
                                            <div class="video-player" item="0">
                                                <div id="player" class=""></div>
                                            </div>
                                            <script>

                                                var container = document.getElementById("player");

                                                // install the player
                                                var fpplayer = flowplayer(container, {
                                                    playlist: [<?= $playlist ?>],
                                                    //customPlaylist: true,
                                                    rtmp: "rtmp://s3b78u0kbtx79q.cloudfront.net/cfx/st",
                                                    ratio: 9/16
                                                });
                                                if("<?= $items[0]->thumbnail ?>"){
                                                    $('#player').css("background-image","url(<?= $items[0]->thumbnail ?>)");
                                                }
                                                $(document).on('click',  '.change-source', function(){
                                                    var path = $(this).attr('path');
                                                    var thumb = $(this).attr('thumb');
                                                    var title = $(this).attr('title');
                                                    var item = $(this).attr('item');
                                                    fpplayer.error = fpplayer.loading = false;
                                                    fpplayer.play(parseInt(item));
                                                });
                                                fpplayer.on("ready", function(e, api) {
                                                    var video = api.video;
                                                    $('.video-player').attr('item',video.index);
                                                    $('.play-icon').hide();
                                                    $(".play-icon").each(function(){
                                                        $(this).find('img').attr('src','<?= Yii::$app->assetManager->getPublishedUrl('@BRUSHAsset') ?>/img/play_icon.png');
                                                    });
                                                    $('.play-icon.item-'+video.index).show();
                                                    
                                                    sliderItem(video.index);
                                                });
                                                fpplayer.on("pause", function(e, api) {
                                                    console.log("pause");
                                                    var item = $(".video-player").attr('item');
                                                    $('.play-icon.item-'+item).find('img').attr('src','<?= Yii::$app->assetManager->getPublishedUrl('@BRUSHAsset') ?>/img/pause_icon.png');
                                                });
                                                fpplayer.on("resume", function(e, api) {
                                                    console.log("playing");
                                                    var item = $(".video-player").attr('item');
                                                    $('.play-icon.item-'+item).find('img').attr('src','<?= Yii::$app->assetManager->getPublishedUrl('@BRUSHAsset') ?>/img/play_icon.png');
                                                });
                                                
                                            </script>
                                        </div>
                                        <div class="col-lg-2 visible-lg vertical-video">
                                            <div class="video-wrapper">
                                                <div class="video-slider-block">
                                                    <?php foreach ($items as $key => $value): ?>
                                                    <div class="video-item" item="<?= $key ?>">
                                                        <a class="change-source" path="<?= $value->path ?>" thumb="<?= $value->thumbnail ? $value->thumbnail:'' ?>" title="<?= $value->title ? $value->title:'' ?>" item="<?= $key ?>">
                                                            <div class="video-frame"></div>
                                                            <?php if($value->thumbnail): ?>
                                                            <img class="img-responsive video-thumbnail" src="<?= $value->thumbnail ?>">
                                                            <?php endif; ?>
                                                            <div class="play-icon item-<?= $key ?>" style="display: none;"><img class="img-responsive" src="<?= Yii::$app->assetManager->getPublishedUrl('@BRUSHAsset') ?>/img/play_icon.png"></div>
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
                                                <?php if($value->thumbnail): ?>
                                                <img class="img-responsive video-thumbnail" src="<?= $value->thumbnail ?>">
                                                <?php endif; ?>
                                                <div class="play-icon item-<?= $key ?>" style="display: none;"><img class="img-responsive" src="<?= Yii::$app->assetManager->getPublishedUrl('@BRUSHAsset') ?>/img/play_icon.png"></div>
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
                            <section class="gallery-comment animated fadeInRight" data-showonscroll="true" data-animation="fadeIn">
                                <?php 
                                if($comment){
                                    echo commentBox::widget(['model'=>$comment, 'top_model'=>$top_comment, 'pagination'=>$pages->getPage(), 'title'=>$model->name, 'category'=>'video', 'id_category'=>$model->id, '_parent'=>null]);
                                }else{ ?>
                                <!--<label class="text-center text-danger">ยังไม่มีคอมเม้นต์</label>-->
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

$this->registerJsFile(Yii::$app->assetManager->getPublishedUrl('@BRUSHAsset')."/js/player.js", ['depends' => [\yii\web\JqueryAsset::className()]]);