<?php

use kartik\sortinput\SortableInput;
use app\models\GalleryImagesModel;
use yii\helpers\Html;
use app\components\helpFunction;
?>
<style>
    .gallery-sort .img{
    }
    .gallery-sort .caption{
    }
    .gallery-sort .action{
        margin-top: 2.5%;
    }
    .gallery-sort .sort{
        font-size: 2.5em;
        margin-top: 1.5%;
    }
    .gallery-sort .sort a{
        margin: 5px;
        color: #999999;
    }
    .gallery-sort .sort a:hover, .gallery-sort .sort a:focus{
        color: #333333;
    }
    
</style>
<?php
$image = GalleryImagesModel::find()->where(['ref' => $model->ref])->orderBy(['sorting'=>SORT_ASC])->all();
if(!$image){ ?>
<h1 class="text-center text-danger">ท่านยังไม่ได้อัพโหลดรูปภาพ</h1>
<?php }
else{
$item = [];
foreach ($image as $value) {
    if(Yii::$app->controller->action->id == "add"){
    $link = '<a href="/gallery/sortable?data-selected='.$value->id.'&sort=up&add=true" class="" title="เลื่อนตำแหน่งขึ้นบน"><i class="fa fa-arrow-circle-o-up" aria-hidden="true"></i></a>'
            . '<a href="/gallery/sortable?data-selected='.$value->id.'&sort=down&add=true" class="" title="เลื่อนตำแหน่งลงล่าง"><i class="fa fa-arrow-circle-o-down" aria-hidden="true"></i></a>';
    }
    else{
        $link = '<a href="/gallery/sortable?data-selected='.$value->id.'&sort=up" class="" title="เลื่อนตำแหน่งขึ้นบน"><i class="fa fa-arrow-circle-o-up" aria-hidden="true"></i></a>'
                . '<a href="/gallery/sortable?data-selected='.$value->id.'&sort=down" class="" title="เลื่อนตำแหน่งลงล่าง"><i class="fa fa-arrow-circle-o-down" aria-hidden="true"></i></a>';
    }
    array_push($item, ['content' => 
                            '<div class="row gallery-sort">'
                                    . '<div class="img col-md-2 col-xs-12">'.
                                    Html::img($value->path.'thumbnail/'.$value->real_name, ['min-width'=>'100', 'class' => 'img-responsive'])
                                    . '</div>'
                                . '<div class="col-md-4 col-xs-12 caption" id="caption-'.$value->id.'">'
                                    . '<div class="text-center"><label class="title">'.helpFunction::cutTextByLength($value->title,20).'</label></div>'
                                    . '<div class="text-center"><label class="detail">'.helpFunction::cutTextByLength($value->detail,20).'</label></div>'
                                . '</div>'
                                . '<div class="col-md-3 col-xs-6 action">'
                                    . '<label class="btn btn-info edit-caption" data-selected="'.$value->id.'">แก้ไข Caption</label>'
                                    .'<input type="hidden" name="data-selected" value="'.$value->id.'">'
                                . '</div>'
                                . '<div class="col-md-3 col-xs-6 sort">'
                                    . $link
                                . '</div>'
                            .'</div>'
                            .'<div class="clearfix"></div>'
                        ]);
     
}

// Scenario # 1: Basic horizontal sortable-input with ActiveForm. Display
// the stored value of the delimited sort order and set it to readonly.
echo SortableInput::widget([
    'name'=> 'sort_list_1',
    'items' => $item,
    'hideInput' => true,
    'options' => ['class'=>'form-control','id'=>'update-drag-item', 'readonly'=>true]
]);
?>
<?= '<input type="hidden" name="data-to" id="link-to" value="gallery">' ?>
<?php } ?>