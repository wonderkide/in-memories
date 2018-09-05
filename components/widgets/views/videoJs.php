<?php

/*$this->registerCssFile("https://cdn.plyr.io/3.4.3/plyr.css", [
    'depends' => ['yii\web\YiiAsset','yii\bootstrap\BootstrapAsset'],
]);
$this->registerJsFile('https://cdn.plyr.io/3.4.3/plyr.js');*/
?>
<?php
    /*echo \wbraganca\videojs\VideoJsWidget::widget([
        'options' => [
            'class' => 'video-js vjs-default-skin vjs-big-play-centered',
            'poster' => "http://www.videojs.com/img/poster.jpg",
            'controls' => true,
            'preload' => 'auto',
            'width' => '970',
            'height' => '400',
        ],
        'tags' => [
            'source' => [
                ['src' => 'http://vjs.zencdn.net/v/oceans.mp4', 'type' => 'video/mp4'],
                ['src' => 'http://vjs.zencdn.net/v/oceans.webm', 'type' => 'video/webm']
            ],
            'track' => [
                ['kind' => 'captions', 'src' => 'http://vjs.zencdn.net/vtt/captions.vtt', 'srclang' => 'en', 'label' => 'English']
            ]
        ]
    ]);*/
?>
<?php
use app\models\VideoModel;
use app\models\CommentModel;
use app\components\helpFunction;
use app\models\UserModel;
use app\assets\PlyrAsset;

PlyrAsset::register($this);
?>
<style>
    .plyr video{
        height: 200px;
    }
</style>
<div class="container">
    <!-- Title Page -->
    <div class="row">
        <div class="col-md-12">
            <div class="gallery cat-widget animated fadeIn">
                <div class="widget-title">
                            <h3><a href="<?= Yii::$app->seo->getUrl('video') ?>">VIDEO</a></h3>
                            <span class="sub-title">คลิปความทรงจำ</span>

                            <div class="sep-widget-tri"></div>
                            <div class="clearfix"></div>
                </div>
            </div>
            <!--<div class="title-page">
                <h2 class="title">Memory</h2>
                <h3 class="title-description">บันทึกความทรงจำ</h3>
            </div>-->
        </div>
    </div>
    <!-- End Title -->
    
    <!-- group -->
    <div class="row">
        <?php 
        if($model){
        foreach ($model as $row) { 
            //show first video
            if($row->title){
                $video = VideoModel::getFirstItem($row->id);
            }
            else{
                $video = null;
            }
            $count_comment = CommentModel::countComment($row->id, 'video');
            $user = UserModel::findOne($row->id_user);
        ?>


        <?php if($video): ?>
        <!-- Start item -->
    	<div class="col-md-4 memory-box">
            <!--<a href="<?= Yii::$app->seo->getUrl('video/view') ?>/<?= $row->id ?>">-->
            <div class="image-wrap" id="row-<?= $row->id ?>">
                    <div class="hover-wrap">
                        <span class="overlay-img"></span>
                        <span class="overlay-text-thumb"><?= ucfirst($row->title) ?></span>
                    </div>
                    <div class="label label-top">
                            <div class="label-text">
                                <span class="view pull-left"><i class="fa fa-eye" aria-hidden="true"></i> <?= $row->read ?></span>
                                <span class="comment pull-right"><i class="fa fa-comments" aria-hidden="true"></i> <?= $count_comment ?></span>
                                <div class="clearfix"></div>
                            </div>
                            <div class="label-bg"></div>
                        </div>
                    <video poster="/path/to/poster.jpg" id="player-<?= $row->id ?>" playsinline controls>
                        <source src="<?= $video ? $video->path : $video ?>" type="video/mp4">
                        <!--<source src="http://vjs.zencdn.net/v/oceans.webm" type="video/webm">-->

                        <!-- Captions are optional -->
                        <!--<track kind="captions" label="English captions" src="/path/to/captions.vtt" srclang="en" default>-->
                    </video>
                    <script>
                        const player<?= $row->id ?> = new Plyr('#player-<?= $row->id ?>');

                        $("#row-<?= $row->id ?>").mouseenter(function() {
                            player<?= $row->id ?>.play();
                        }).mouseleave(function() {
                            player<?= $row->id ?>.pause();
                        });
                        // Bind event listener
                        /*function on(selector, type, callback) {
                            document.querySelector(selector).addEventListener(type, callback, false);
                        }*/
                        // Play
                        /*on('.plyr', 'mouseover', () => { 
                            var v = $(this).find('video');
                            var id = v.attr('id');
                            id.play();
                        });*/
                        
                        /*document.addEventListener('DOMContentLoaded', () => { 
                            // This is the bare minimum JavaScript. You can opt to pass no arguments to setup.
                            const player<?= $row->id ?> = new Plyr('#player-<?= $row->id ?>');

                            // Bind event listener
                            function on(selector, type, callback) {
                                document.querySelector(selector).addEventListener(type, callback, false);
                            }

                            // Play
                            on('.plyr', 'mouseover', () => { 
                                var v = $(this).find('video');
                                var id = v.attr('id');
                                //id.play();
                                console.log(v[0]);
                            });

                            // Pause
                            on('.js-pause', 'click', () => { 
                              player.pause();
                            });

                            // Stop
                            on('.js-stop', 'click', () => { 
                              player.stop();
                            });

                            // Rewind
                            on('.js-rewind', 'click', () => { 
                              player.rewind();
                            });

                            // Forward
                            on('.js-forward', 'click', () => { 
                              player.forward();
                            });
                        });*/
                    </script>
                </div>
            <!--</a>-->
            <a href="<?= Yii::$app->seo->getUrl('video/view') ?>/<?= $row->id ?>">
                <h3 class="title"><?= $row->title ?></h3>
            </a>
            <div class="meta-info">
                
                <span class="author"><i class="fa fa-user"></i><a href="<?= Yii::$app->seo->getUrl('wonder/user') ?>/<?= $user->id ?>"> <?= $user->nickname ? $user->nickname:$user->username ?></a></span>

                &nbsp;&nbsp;<span class="date-time"><i class="fa fa-clock-o"></i> <?= helpFunction::humanTiming(strtotime($row->create_date)) ?></span>

            </div>
        </div>
        <?php endif; ?>
        <!-- End item -->
        <?php
        }}else{ ?>
        <p class="text-danger text-center">ไม่พบข้อมูล</p>
        <?php } ?>
    </div>
    <!-- End group -->
</div>