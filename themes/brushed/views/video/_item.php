<?php
use yii\helpers\Url;
use kartik\widgets\FileInput;
use kartik\sortinput\SortableInput;
use yii\bootstrap\Tabs;
use app\components\helpFunction;
//phpinfo();exit();
?>

<style>
    .video-model-manage .tab-content{
        background: #fff;
    }
    .video-model-manage .nav-tabs > li > a {
        background: #e6e6e6;
    }
    .video-model-manage .nav-tabs > li.active > a{
        background: #fff;
    }
    .video-model-manage .img{
    }
    .video-model-manage .caption{
    }
    .video-model-manage .action{
        margin-top: 2.5%;
    }
    .video-model-manage .sort{
        font-size: 2.5em;
        margin-top: 1.5%;
    }
    .video-model-manage .sort a{
        margin: 5px;
        color: #999999;
    }
    .video-model-manage .sort a:hover, .video-model-manage .sort a:focus{
        color: #333333;
    }
    .preview img, .preview video{
        max-width: 100px;
    }
    video{
        max-width: 300px;
        max-height: 200px
    }
    @media (min-width: 768px){
        video{
            max-width: 400px;
            max-height: 250px
        }
    }
</style>
<?php $this->beginContent('@app/views/layouts/_tab_personal.php', ['active' => 'video']); ?>
    <div class="col-md-4">
        <?= $this->render('_menu') ?>
    </div>
    <div class="col-md-8">
        <div class="video-model-manage">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">จัดการ video :: <?= $model->name ?></h3>
                </div>
                <div class="panel-body">
                    <?php if($items): ?>
                    <?php 
                    $sort = [];
                    foreach ($items as $value) {
                            $link = '<a href="/video/sortable?data-selected='.$value->id.'&sort=up" class="" title="เลื่อนตำแหน่งขึ้นบน"><i class="fa fa-arrow-circle-o-up" aria-hidden="true"></i></a>'
                                    . '<a href="/video/sortable?data-selected='.$value->id.'&sort=down" class="" title="เลื่อนตำแหน่งลงล่าง"><i class="fa fa-arrow-circle-o-down" aria-hidden="true"></i></a>';
                        array_push($sort, ['content' => 
                                                '<div class="row gallery-sort">'
                                                        . '<div class="img col-md-2 col-xs-12">'.
                                                        '<video class="kv-preview-data" controls><source src="'. $value->path .'" type="video/mp4"></video>'
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
                    ?>
                    <?php echo Tabs::widget([
                        'items' => [
                            [
                                'label' => 'เพิ่ม-ลบวีดีโอ',
                                'content' => FileInput::widget([
                                    'name' => 'upload_ajax[]',
                                    'options' => ['multiple' => true,'enctype'=>'multipart/form-data','accept' => 'video/mp4'], //'accept' => 'image/*' หากต้องเฉพาะ image
                                     'pluginOptions' => [
                                         'overwriteInitial'=>false,
                                         //'initialPreviewAsData'=>true,
                                         'initialPreviewShowDelete'=>true,
                                         'initialPreview'=> $initialPreview,
                                         'initialPreviewConfig'=> $initialPreviewConfig,
                                         'uploadUrl' => Url::to(['/video/upload-ajax']),
                                         'uploadExtraData' => [
                                             'id' => $model->id,
                                         ],
                                         'maxFileCount' => 100,
                                         //'maxFileSize'=>3000
                                         'previewFileType' => 'any'
                                     ]
                                 ]),
                                'active' => $active ? FALSE:true
                            ],
                            [
                                'label' => 'จัดการวีดีโอ',
                                'content' => SortableInput::widget([
                                                'name'=> 'sort_list_1',
                                                'items' => $sort,
                                                'hideInput' => true,
                                                'options' => ['class'=>'form-control','id'=>'update-drag-item', 'readonly'=>true]
                                            ]),
                                'active' => $active ? true:FALSE
                            ]
                        ],
                    ]);
                    ?>
                    <?php else: ?>
                    <?=
                    FileInput::widget([
                       'name' => 'upload_ajax[]',
                       'options' => ['multiple' => true,'accept' => 'video/mp4'], //'accept' => 'image/*' หากต้องเฉพาะ image
                        'pluginOptions' => [
                            'overwriteInitial'=>false,
                            'initialPreviewShowDelete'=>true,
                            'initialPreview'=> $initialPreview,
                            'initialPreviewConfig'=> $initialPreviewConfig,
                            'uploadUrl' => Url::to(['/video/upload-ajax']),
                            'uploadExtraData' => [
                                /*'ref' => $model->ref,*/
                                'id' => $model->id,
                            ],
                            'maxFileCount' => 100,
                        ]
                    ]);
                    ?>
                    <?php endif; ?>
                </div>
            </div>

        </div>
        <div class="video-canvas">
        </div>
    </div>
<?php
echo '<input type="hidden" name="data-to" id="link-to" value="video">';
// register your javascript
$js = <<< JS
$(".kv-file-zoom").on("click", function() {
    $(".modal-backdrop").hide();
});
var canvas_count = 1;
setTimeout(function(){
    $('.kv-file-content video').each(function() {
        var img_src = $(this).attr('poster');
        if(!img_src){

            var id = $(this).attr('id');
            var canvas_id = "video-canvas-"+canvas_count;

            $(".video-canvas").append('<canvas id="'+canvas_id+'" style="display:none"></canvas>');
            //$(".video-canvas").append('<a id="link-'+canvas_id+'">#</a>');

            document.querySelector("#"+canvas_id).style.display = 'none';

            var _CANVAS = document.querySelector("#"+canvas_id),
            _CTX = _CANVAS.getContext("2d"),
            _VIDEO = document.querySelector("#"+id);
            _VIDEO.load();
            _VIDEO.style.display = 'inline';
        
            _VIDEO.addEventListener('loadedmetadata', function() { 
                var video_duration = _VIDEO.duration,
                    duration_options_html = '';
                //document.querySelector("#set-video-seconds").innerHTML = duration_options_html;

                // Show the dropdown container
                //document.querySelector("#link-"+canvas_id).style.display = 'block';

                // Set canvas dimensions same as video dimensions
                _CANVAS.width = _VIDEO.videoWidth;
                _CANVAS.height = _VIDEO.videoHeight;
        
                _VIDEO.currentTime = _VIDEO.duration-2;
            });
            //_VIDEO.currentTime = 4*canvas_count;
            _VIDEO.timeupdate;
        
            setTimeout(function(){
                _CTX.drawImage(_VIDEO, 0, 0, _VIDEO.videoWidth, _VIDEO.videoHeight);
                var img = _CANVAS.toDataURL();
                //document.querySelector("#link-"+canvas_id).setAttribute('href', img);
                //document.querySelector("#link-"+canvas_id).setAttribute('download', 'thumbnail.png');
                $.ajax({
                        type: "POST",
                        url: '/video/upload-thumbnail',
                        data: {"content":_CANVAS.toDataURL(), "item": id},
                        success: function(response){
                            console.log(response);
                            _VIDEO.currentTime = 0;
                            _VIDEO.timeupdate;
                        }
                });
                canvas_count += 1;
            }, 1000);
            
        }
    });
}, 100);
JS;
$this->registerJs($js);
?>
<?php $this->endContent(); ?>