<?php

?>
<div class="row">
    <div class="col-md-12">
        <div class="main-memory-action">
            
        </div>
        <div class="memory cat-widget wdg-cat-opposite">
            <div class="widget-title">
                <h3><a href="<?= Yii::$app->seo->getUrl('video') ?>">VIDEO</a></h3>
                <span class="sub-title">กล่องวีดีโอ</span>

                <div class="sep-widget-tri"></div>
                <div class="clearfix"></div>
            </div>
            <div class="widget-content">
                <div class="protected-data no-data">
                    <h3 class="text-danger text-center"><span class="<?= $content->name ?>"></span></h3>
                    <h3 class="text-danger text-center"><?= $content->content ?></h3>
                </div>
            </div>
                
        </div>
    </div>
</div>