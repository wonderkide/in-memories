<?php
use app\models\GalleryImagesModel;
use app\models\CommentModel;
?>
<style>
    .label {
        border-radius: 0;
    }
    .gallery-item{
        margin-bottom: 15px;
    }
    .gallery-item .gallery-link{
        
    }
    .gallery-item .gallery-item-wrapper {
        overflow: hidden;
        position: relative;
    }
    .gallery-item .gallery-item-wrapper img:hover, .gallery-item .gallery-item-wrapper img:focus{
        -webkit-filter: grayscale(0); /* Safari 6.0 - 9.0 */
        filter: grayscale(0);
        -moz-transform: scale(1.1);
        -webkit-transform: scale(1.1);
        transform: scale(1.1);
    }
    .gallery-item .gallery-item-wrapper img{
        -webkit-filter: grayscale(0.8); /* Safari 6.0 - 9.0 */
        filter: grayscale(0.5);
        -webkit-transition-duration: 1s; /* Safari */
        transition-duration: 1s;
        width: 100%;
    }
</style>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="gallery cat-widget animated fadeIn">
                <div class="widget-title">
                            <h3><a href="<?= Yii::$app->seo->getUrl('gallery') ?>">GALLERY</a></h3>
                            <span class="sub-title">ภาพความทรงจำ</span>

                            <div class="sep-widget-tri"></div>
                            <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="gallery-block">
            
            <?php 
            if($model){
            foreach ($model as $row) { 
                $images = GalleryImagesModel::getImageFirst($row->id);
                if($images){
                    $comment = CommentModel::countComment($row->id, 'gallery');
            ?>

            <div class="col-md-4 col-sm-6 gallery-item">
                <div class="gallery-item-wrapper animated fadeInLeft" data-showonscroll="true" data-animation="fadeIn">
                    <a href="<?= Yii::$app->seo->getUrl('gallery/view') ?>/<?= $row->ref ?>" class="gallery-link">
                        <img class="img-responsive" src="<?= $images ?>" alt="in-memories-gallery" />
                        <div class="label label-top">
                            <div class="label-text">
                                <span class="view pull-left"><i class="fa fa-eye" aria-hidden="true"></i> <?= $row->read ?></span>
                                <span class="comment pull-right"><i class="fa fa-comments" aria-hidden="true"></i> <?= $comment ?></span>
                                <div class="clearfix"></div>
                            </div>
                            <div class="label-bg"></div>
                        </div>
                        <div class="label">
                            <div class="label-text">
                                <span><?= strtoupper($row->name) ?></span>
                            </div>
                            <div class="label-bg"></div>
                        </div>
                    </a>
                </div>
            </div>
            <?php }}}
            else{ ?>
            <p class="text-danger text-center">ไม่พบข้อมูล</p>
            <?php } ?>
        </div>
    </div>
</div>