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
class PlyrAsset extends AssetBundle {

    public $sourcePath = '@BRUSHAsset';
    public $css = [
        'plyr/dist/plyr.css',
    ];
    public $js = [
        'plyr/dist/plyr.js',
        
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
