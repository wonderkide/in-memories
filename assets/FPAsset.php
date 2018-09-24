<?php

/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * @since 2.0
 */
class FPAsset extends AssetBundle {

    public $sourcePath = '@BRUSHAsset';
    public $css = [
        'flowplayer-7.2.6/skin/skin.css',
        'css/player.css',
    ];
    public $js = [
        'flowplayer-7.2.6/flowplayer.min.js',
        'flowplayer-7.2.6/plugins/flowplayer.hlsjs.light.min.js',
        'flowplayer-7.2.6/plugins/flowplayer.vod-quality-selector.js',
        'flowplayer-7.2.6/plugins/flowplayer.thumbnails.min.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset',
        'yii\web\JqueryAsset',
        'app\assets\importWDAsset',
        'app\assets\BRUSHAsset'
    ];
    
    public $jsOptions = array(
        'position' => \yii\web\View::POS_HEAD
    );

    public function init() {
        $this->publishOptions['forceCopy'] = (YII_ENV == 'dev') ? TRUE : FALSE;
        parent::init();
    }

}
