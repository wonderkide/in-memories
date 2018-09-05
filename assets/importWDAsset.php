<?php

/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * @author wonderkide
 * @since 2.0
 */
class importWDAsset extends AssetBundle {

    public $sourcePath = '@WDAsset';
    public $css = [
        'css/main.css',
        'css/theme.css',
        'css/animate.css',
        'css/img-selected/imgareaselect-animated.css',
        'css/jquery-ui.css',
    ];
    public $js = [
        'js/jquery-ui.min.js',
        'js/main.js',
        //'js/jssor.slider.mini.js',
        'js/img-selected/jquery.imgareaselect.pack.js',
        //'js/camera_slide.js',
        
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
    
    public $jsOptions = array(
        'position' => \yii\web\View::POS_HEAD
    );

    public function init() {
        $this->publishOptions['forceCopy'] = (YII_ENV == 'dev') ? TRUE : FALSE;
        parent::init();
    }

}
