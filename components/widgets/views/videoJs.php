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
                            <span class="sub-title">กล่องวีดีโอ</span>

                            <div class="sep-widget-tri"></div>
                            <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Title -->
    
    <!-- group -->
    <div class="row">
        <?php 
        if($model){
        foreach ($model as $row) { 
            //show first video
            if($row->name){
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
    	<div class="col-md-4 memory-box animated fadeInRight" data-showonscroll="true" data-animation="fadeInRight">
            <!--<a href="<?= Yii::$app->seo->getUrl('video/view') ?>/<?= $row->id ?>">-->
            <div class="image-wrap" id="row-<?= $row->id ?>">
                    <div class="hover-wrap">
                        <span class="overlay-img"></span>
                        <span class="overlay-text-thumb"><?= ucfirst($row->name) ?></span>
                    </div>
                    <div class="label label-top">
                            <div class="label-text">
                                <span class="view pull-left"><i class="fa fa-eye" aria-hidden="true"></i> <?= $row->read ?></span>
                                <span class="comment pull-right"><i class="fa fa-comments" aria-hidden="true"></i> <?= $count_comment ?></span>
                                <div class="clearfix"></div>
                            </div>
                            <div class="label-bg"></div>
                        </div>
                    <video poster="<?= $video->thumbnail ? $video->thumbnail:'' ?>" id="player-<?= $row->id ?>" playsinline controls>
                        <source src="<?= $video ? $video->path : $video ?>" type="video/mp4">
                    </video>
                    <script>
                        const player<?= $row->id ?> = new Plyr('#player-<?= $row->id ?>');

                        $("#row-<?= $row->id ?>").mouseenter(function() {
                            player<?= $row->id ?>.play();
                        }).mouseleave(function() {
                            player<?= $row->id ?>.pause();
                        });
                    </script>
                </div>
            <!--</a>-->
            <a href="<?= Yii::$app->seo->getUrl('video/view') ?>/<?= $row->id ?>">
                <h3 class="title"><?= $row->name ?></h3>
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