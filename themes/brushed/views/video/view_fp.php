<?php
/*$items = [];
foreach ($imageModel as $value) {
    array_push($items, [
        'url' => $value->path.$value->real_name, //original
        'src' => $value->path.'thumbnail/'.$value->real_name, //thumb
        'options' => array('title' => $value->title),//title
    ]); 
    
}*/
use app\components\widgets\LikeBox;
use app\components\widgets\commentBox;
use app\components\helpFunction;
use app\models\ContentModel;
use yii\widgets\LinkPager;
//use app\assets\PlyrAsset;

//PlyrAsset::register($this);
use app\assets\FPAsset;

FPAsset::register($this);
?>
<style>
    /*
  sprite dimensions: 982x420
*/
#player {
  width: 100%; /* same as sprite */
  padding: 0;
  /*margin: 0 0 440px 0;*/ /* 420 + 20 margin bottom */
  /* the following 3 directives not needed if the playlist is below the player from the start */
  -webkit-transition: margin .8s;
  -moz-transition: margin .8s;
  transition: margin .8s;
}
#player.is-splash {
  margin: 0;
}
#player.is-splash .fp-play {
  display: none;
}
 
/* playlist as grid */
#player .fp-playlist {
    width: 100%;
  z-index: 1; /* overlay the UI */
  /*background: #fff url(//flowplayer.com/media/img/demos/playlist/grid.jpg) center no-repeat;*/
  /* 982 not divisible by 4, so 980 + 1px padding each side */
  padding: 0 1px;
  /*position: absolute;*/
  left: 0;
  bottom: -440px; /* -420 - 20 */
  /* the following 3 directives not needed if the playlist is below the player from the start */
  -webkit-transition: all .8s;
  -moz-transition: all .8s;
  transition: all .8s;
  background: #fff;
}
#player.is-splash .fp-playlist {
  padding: 60px 1px; /* (980 / 16 * 9 - 420) / 2 = 65.625 */
  bottom: 0;
}
 
/* the playlist item elements */
#player .fp-playlist a {
  width: 245px;  /* 980 / 4 */
  height: 140px; /* 420 / 3 */
  display: inline-block;
}
#player .fp-playlist a.is-active, #player .fp-playlist a:hover {
  background-image: url(//releases.flowplayer.org/6.0.5/skin/img/play_white.png);
  background-position: center;
  background-repeat: no-repeat;
}
@media(-webkit-min-device-pixel-ratio: 2), (min-resolution: 2dppx) {
  #player .fp-playlist a.is-active, #player .fp-playlist a:hover {
    background-image: url(//releases.flowplayer.org/6.0.5/skin/img/play_white@x2.png);
  }
}
#player .fp-playlist a:hover {
  background-size: 12%;
}
#player .fp-playlist a.is-active {
  background-size: 20%;
}
</style>
<section id="video-view" class="page">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="memory cat-widget">
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

                                            <label>แกลอรี่ : <span><?= $model->name ?></span></label><br>
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
                                <div class="gallery-image">
                                    <div id="player" class="is-splash is-closeable"></div>
                                    <script>
                                        // ensure that DOM is ready
                                        window.onload = function () {

                                          var container = document.getElementById("player"),

                                          getVideoName = function (i) {
                                            /*
                                              we do not have 12 videos available
                                              so repeat videos named night1 thru night6
                                              fill grid with 6 videos by clamping index count between 0 and 5
                                            */
                                            return "night" + (i % 6 + 1);
                                          },

                                          getPlaylist = function () {
                                              var playlist = [], i;
                                                  playlist.push({
                                                    sources: [
                                                        { type: "video/mp4",
                                                          src:  "/uploads/video/54/5012c0355b85246b47f815fc0cbdd8a5.mp4" 
                                                        }
                                                    ]
                                                  });
                                                  playlist.push({
                                                    sources: [
                                                        { type: "video/mp4",
                                                          src:  "/uploads/video/3/a6dcda6ff96a82736746ab2bc0b991ab.mp4" 
                                                        }
                                                    ]
                                                  });
                                                  playlist.push({
                                                    sources: [
                                                        { type: "video/mp4",
                                                          src:  "/uploads/video/3/517521d1d054a3e0d260e3b756053d39.mp4" 
                                                        }
                                                    ]
                                                  });
                                            /*var playlist = [], i;

                                            for (i = 0; i < 12; i += 1) {
                                              playlist.push({
                                                sources: [
                                                  { type: "video/mp4",
                                                    src:  "/uploads/video/54/5012c0355b85246b47f815fc0cbdd8a5.mp4" },
                                                  { type: "video/mp4",
                                                    src:  "/uploads/video/3/a6dcda6ff96a82736746ab2bc0b991ab.mp4" },
                                                  { type: "video/mp4",
                                                    src:  "/uploads/video/3/517521d1d054a3e0d260e3b756053d39.mp4" }
                                                ]
                                              });
                                            }

                                            return playlist;*/
                                            /*return sources: [
                                                  { type: "video/mp4",
                                                    src:  "/uploads/video/54/5012c0355b85246b47f815fc0cbdd8a5.mp4" },
                                                  { type: "video/mp4",
                                                    src:  "/uploads/video/3/a6dcda6ff96a82736746ab2bc0b991ab.mp4" },
                                                  { type: "video/mp4",
                                                    src:  "/uploads/video/3/517521d1d054a3e0d260e3b756053d39.mp4" }
                                                ];*/
                                            return playlist;
                                          };


                                          // install the player
                                          flowplayer(container, {
                                            playlist: getPlaylist(),
                                            customPlaylist: true,
                                            //qualities: ["216p", "360p", "720p", "1080p"],
                                            //defaultQuality: "360p",
                                            rtmp: "rtmp://s3b78u0kbtx79q.cloudfront.net/cfx/st",
                                            ratio: 9/16
                                          });

                                        };
                                        /*const player = new Plyr('#player');
                                        player.source = {
                                            type: 'video',
                                            title: 'Example title',
                                            sources: [
                                                {
                                                    src: '/uploads/video/54/5012c0355b85246b47f815fc0cbdd8a5.mp4',
                                                    type: 'video/mp4',
                                                    size: 1
                                                },
                                                {
                                                    src: '/uploads/video/3/a6dcda6ff96a82736746ab2bc0b991ab.mp4',
                                                    type: 'video/mp4',
                                                    size: 2
                                                },
                                                {
                                                    src: '/uploads/video/3/517521d1d054a3e0d260e3b756053d39.mp4',
                                                    type: 'video/mp4',
                                                    size: 3
                                                }
                                            ]
                                        };*/
                                    </script>
                                </div>

                            </div>
                            <section class="gallery-comment">
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
$js = <<< JS
$('#slide-gallery a').on("click", function(e) {
    setTimeout(function(){
        if($('#blueimp-gallery').hasClass("blueimp-gallery-display")){
            $('header .sticky-nav').css('z-index', 99);
        }
    }, 100);
});
$(document).on("click", function(e) {
    if($('#blueimp-gallery').hasClass("blueimp-gallery-display")){
    }
    else{
        $('header .sticky-nav').css('z-index', 1001);
    }
});

JS;
 
// register your javascript
$this->registerJs($js);