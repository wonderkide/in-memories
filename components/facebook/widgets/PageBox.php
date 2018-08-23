<?php
namespace app\components\facebook\widgets;

use Yii;
use yii\base\Widget;


class PageBox extends Widget {
    
    public $pageURL = null;
    public $page_box_width = null;
    public $page_box_height = null;
    public $page_box_small_header = false;
    public $page_box_hide_cover = false;

    public function init() {
        $this->pageURL = Yii::$app->facebook->pageURL;
    }

    public function run() {
        if($this->page_box_small_header){
            $header = 'true';
        }
        else{
            $header = 'false';
        }
        if($this->page_box_hide_cover){
            $hide = 'true';
        }
        else{
            $hide = 'false';
        }
        return $this->render('PageBox', 
                [
                    'pageURL' => $this->pageURL,
                    'page_box_width' => $this->page_box_width,
                    'page_box_height' => $this->page_box_height,
                    'header' => $header,
                    'hide' => $hide,
                ]);
    }
    
}
