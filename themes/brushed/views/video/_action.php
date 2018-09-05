<?php
use app\components\widgets\reportButton;
?>
<div class="action">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <ul class="nav-pills navbar-right list-style-none">
                    <li><a class="btn btn-default btn-sm" href="/video/comment/<?= $model->id ?>">ตอบกลับ</a></li>
                    <?php 
                    if($model->id_user == Yii::$app->user->id){ ?>
                        <li><a class="btn btn-default btn-sm" href="/video/item/<?= $model->id ?>"><span class="glyphicon glyphicon-pencil"></span> แก้ไข</a></li>
                    <?php } ?>
                    <li><?= reportButton::widget(['id_cat'=>$model->id, 'id_user'=>$model->id_user, 'category'=>'video', 'btn_size'=>'sm']) ?></li>
                </ul>
            </div>
                
        </div>
            
    </div>
        
</div>