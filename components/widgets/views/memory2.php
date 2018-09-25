<?php
use app\models\GalleryImagesModel;
use app\models\MemoryModel;
use app\models\CommentModel;
use app\components\helpFunction;
use app\models\UserModel;

?>

<div class="container">
    <!-- Title Page -->
    <div class="row">
        <div class="col-md-12">
            <div class="gallery cat-widget animated fadeIn">
                <div class="widget-title">
                            <h3><a href="<?= Yii::$app->seo->getUrl('memory') ?>">MEMORY</a></h3>
                            <span class="sub-title">กล่องความทรงจำ</span>

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
    <!-- End Title Page -->
    
    <!-- People -->
    <div class="row">
        <?php 
        if($model){
        foreach ($model as $row) { 
            //show image block if image
            if($row->image_thumb){
                $img = $row->image_thumb;
            }
            else if($row->gallery_tags && $row->gallery_tags !=''){
                $tag = explode(',', $row->gallery_tags);
                $img = GalleryImagesModel::getImageFirst($tag[0]);
            }
            else{
                $img = null;
            }
            $count_comment = CommentModel::countComment($row->id, 'memory');
            $user = UserModel::findOne($row->id_user);
        ?>


        
        <!-- Start Profile -->
    	<div class="col-md-4 memory-box animated fadeInRight">
            <a href="<?= Yii::$app->seo->getUrl('memory/view') ?>/<?= $row->id ?>">
                <div class="image-wrap">
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
                    <img src="<?= $img ? $img:Yii::$app->assetManager->getPublishedUrl('@BRUSHAsset').'/img/noimage.png'?>" alt="<?=$row->title?>">
                </div>
            </a>
            <a href="<?= Yii::$app->seo->getUrl('memory/view') ?>/<?= $row->id ?>">
                <h3 class="title"><?= $row->title ?></h3>
            </a>
            <div class="meta-info">
                
                <span class="author"><i class="fa fa-user"></i><a href="<?= Yii::$app->seo->getUrl('wonder/user') ?>/<?= $user->id ?>"> <?= $user->nickname ? $user->nickname:$user->username ?></a></span>

                &nbsp;&nbsp;<span class="date-time"><i class="fa fa-clock-o"></i> <?= helpFunction::humanTiming(strtotime($row->create_time)) ?></span>

            </div>
            
            <p class="profile-description"><?= MemoryModel::filterContent($row->content, $cut) ?></p>
            	
            <?php /*
            <div class="social">
            	<ul class="social-icons">
                	<li><a href="#"><i class="font-icon-social-twitter"></i></a></li>
                    <li><a href="#"><i class="font-icon-social-linkedin"></i></a></li>
                    <li><a href="#"><i class="font-icon-social-google-plus"></i></a></li>
                    <li><a href="#"><i class="font-icon-social-vimeo"></i></a></li>
                </ul>
            </div>
             * 
             */ ?>
        </div>
        <!-- End Profile -->
        <?php
        }}else{ ?>
        <p class="text-danger text-center">ไม่พบข้อมูล</p>
        <?php } ?>
    </div>
    <!-- End People -->
</div>