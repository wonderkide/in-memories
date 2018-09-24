<?php
namespace app\components\widgets;

use Yii;
use yii\base\Widget;
use app\models\VideoModel;
use yii\data\Pagination;

class videoPager extends Widget {
    public $model = null;
    public $model_pager = null;
    public $view = 'videoPager';
    public $pagination;

    public function init() {
        $this->model = VideoModel::find()->where(['show'=>1, 'banned'=>0])->orderBy(['create_date' => SORT_DESC]);
        $count = $this->model->count();
        $this->pagination = new Pagination(['totalCount' => $count, 'pageSize' => 12]);
        $this->model_pager = $this->model->offset($this->pagination->offset)
        ->limit($this->pagination->limit)
        ->all();
        $this->view = 'videoPager';
    }

    public function run() {
        return $this->render($this->view,
                [
                    'model' => $this->model,
                    'pages' => $this->pagination,
                    'model_pager' => $this->model_pager,
                ]);
    }
    
}
