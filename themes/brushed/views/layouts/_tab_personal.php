<?php
use app\components\MyController;
?>
<section class="page">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="tabbable">
                    <ul class="nav nav-tabs" id="personalTab">
                        <li class="<?= $active=='personal'?'active':''?>"><a href="<?= Yii::$app->seo->getUrl('personal') ?>">ข้อมูลส่วนตัว</a></li>
                        <li class="<?= $active=='message'?'active':''?>"><a href="<?= Yii::$app->seo->getUrl('personal/inbox') ?>">ข้อความ</a></li>
                        <li class="<?= $active=='memory'?'active':''?>"><a href="<?= Yii::$app->seo->getUrl('memory/manage') ?>">MEmory</a></li>
                        <li class="<?= $active=='gallery'?'active':''?>"><a href="<?= Yii::$app->seo->getUrl('gallery/personal') ?>">Gallery</a></li>
                        <li class="<?= $active=='video'?'active':''?>"><a href="<?= Yii::$app->seo->getUrl('video/manage') ?>">Video</a></li>
                        <?php if(MyController::checkPermissionRank('alert')){ ?>
                        <li class="<?= $active=='alert'?'active':''?>"><a href="<?= Yii::$app->seo->getUrl('alert') ?>">Alert</a></li>
                        <?php } ?>
                        <?php if(MyController::checkPermissionRank('expend')){ ?>
                        <li class="<?= $active=='expend'?'active':''?>"><a href="<?= Yii::$app->seo->getUrl('expend') ?>">Expend</a></li>
                        <?php } ?>
                        <li class="<?= $active=='games'?'active':''?>"><a href="<?= Yii::$app->seo->getUrl('games/history') ?>">Games</a></li>
                        <li class="<?= $active=='notify'?'active':''?>"><a href="<?= Yii::$app->seo->getUrl('notify') ?>">การแจ้งเตือน</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane fade in active">
                            <?php echo $content; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Modal Caption -->
<div class="modal fade" id="CaptionModal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title center">ข้อมูล Caption</h4>
      </div>
      <div class="modal-body">
            <input id="caption_selected" type="hidden">
            <table class="table table-hover">
                <tr>
                    <td>Title</td>
                    <td><input id="caption_title" type="text"></td>
                </tr>
                <tr>
                    <td>Detail</td>
                    <td><textarea id="caption_detail" rows="4"></textarea></td>
                </tr>
            </table>
      </div>
      <div class="modal-footer">
        <!--<button type="button" class="btn btn-success" data-dismiss="modal">ข้อมูลส่วนตัว</button>-->
        <button onclick="updateCaption()" type="button" class="btn btn-danger btn-sm">Save</button>
      </div>
    </div>
  </div>
</div>