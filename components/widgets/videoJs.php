<?php
namespace app\components\widgets;

use Yii;
use yii\base\Widget;
use app\models\VideoModel;

class videoJs extends Widget {
    public $render = 'index';
    public $model = null;
    public $view = 'videoJs';

    public function init() {
        if(!$this->model){
            $this->model = VideoModel::find()->where(['show'=>1, 'banned'=>0])->orderBy(['create_date' => SORT_DESC])->limit(6)->all();
        }
    }

    public function run() {
        return $this->render($this->view,
                [
                    'model' => $this->model,
                ]);
    }
    
}
