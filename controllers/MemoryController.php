<?php

namespace app\controllers;

use Yii;
use app\models\MemoryModel;
use app\models\MemorySearchModel;
use app\components\MyController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\CommentModel;
use app\models\ContentModel;
use yii\data\Pagination;
use yii\imagine\Image;

/**
 * MemoryController implements the CRUD actions for MemoryModel model.
 */
class MemoryController extends MyController
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all MemoryModel models.
     * @return mixed
     */
    public function actionIndex()
    {
        //$searchModel = new MemorySearchModel();
        //$dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            //'searchModel' => $searchModel,
            //'dataProvider' => $dataProvider,
        ]);
    }
    
    public function actionManage() {
        $this->isLogin();
        $searchModel = new MemorySearchModel();
        $dataProvider = $searchModel->searchByUser(Yii::$app->request->queryParams, Yii::$app->user->id);

        return $this->render('manage', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single MemoryModel model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {   
        $model = MemoryModel::find()->where(['id'=>$id, 'banned'=>0, 'show'=>1])->one();
        if(!$model){
            $content = ContentModel::findOne(['type'=>'no-data']);
            return $this->render('no-data', [
                'content' => $content,
            ]);
        }
        $username = \app\models\UserModel::getName($model->id_user);
        \Yii::$app->view->title = $model->title;
        $comment = CommentModel::find()->where(['id_parent'=>0, 'id_cat'=>$model->id, 'category'=>'memory'])->orderBy(['create_time'=>SORT_ASC]);
        $count = $comment->count();
        // create a pagination object with the total count
        $pagination = new Pagination(['totalCount' => $count, 'pageSize' => 20]);

        // limit the query using the pagination and retrieve the articles
        $comments = $comment->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();
        $top_comment = CommentModel::find()->where(['id_parent'=>0, 'banned'=>0, 'id_cat'=>$model->id, 'category'=>'memory'])->andWhere(['>', 'feeling', 0])->limit(3)->orderBy(['feeling'=>SORT_DESC])->all();
        if($model->id_user != Yii::$app->user->id){
            $this->updateRead($model);
        }
        return $this->render('view', [
            'model' => $model,
            'username' => $username,
            'comment' => $comments,
            'top_comment' => $top_comment,
            'pages' => $pagination,
        ]);
    }

    /**
     * Creates a new MemoryModel model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $this->isLogin();
        if($this->checkBanned()){
            return $this->redirect(Yii::$app->seo->getUrl('wonder/banned'));
        }
        $model = new MemoryModel();

        if ($model->load(Yii::$app->request->post()) ) {
            $model->id_user = Yii::$app->user->id;
            $model->create_time = date('Y-m-d H:i:s');
            $model->read = 0;
            
            $img = $this->findImgTags($model->content);
            $model->image_thumb = $img;
            $model->content = $this->textEditorImageResponsive($model->content);
            if(isset(Yii::$app->request->post()['gallery_tags']) && Yii::$app->request->post()['gallery_tags'] != ''){
                $tag = Yii::$app->request->post()['gallery_tags'];
                $key = implode(',', $tag);
                $model->gallery_tags = $key;
            }
            
            if($model->save()){
                ExpController::createLogEXP(Yii::$app->user->id, $model->id, 'memory', 'create memory');
                return $this->redirect([Yii::$app->seo->getUrl('memory/manage')]);
            }
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing MemoryModel model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $this->isLogin();
        $model = $this->findModel($id);
        if(!$this->checkPermission($model->id_user)){
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        if ($model->load(Yii::$app->request->post())) {
            $model->update_time = date('Y-m-d H:i:s');
            $model->content = $this->textEditorImageResponsive($model->content);
            $img = $this->findImgTags($model->content);
            $model->image_thumb = $img;
            
            if(isset(Yii::$app->request->post()['gallery_tags']) && Yii::$app->request->post()['gallery_tags'] != ''){
                $tag = Yii::$app->request->post()['gallery_tags'];
                $key = implode(',', $tag);
                $model->gallery_tags = $key;
            }
            else{
                $model->gallery_tags = null;
            }
            if($model->save()){
                return $this->redirect([Yii::$app->seo->getUrl('memory/manage')]);
            }
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing MemoryModel model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->isLogin();
        $model = $this->findModel($id);
        if(!$this->checkPermission($model->id_user)){
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        $model->delete();

        return $this->redirect([Yii::$app->seo->getUrl('memory/manage')]);
    }

    /**
     * Finds the MemoryModel model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return MemoryModel the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = MemoryModel::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    public function findImgTags($html) {
        preg_match('/<img[^>]+>/i',$html, $result);
        if($result && $result[0]){
            preg_match( '@src="([^"]+)"@' , $result[0], $match );
            $src = array_pop($match);
            if($src && $src != ''){
                return $this->createThumbnail($src);
            }
        }
        return null;
    }
    
    private function createThumbnail($src){
      $uploadPath   = '/uploads/img/memory/'.end(explode('/',$src));
      Image::thumbnail(Yii::getAlias('@webroot').'/'.$src, 370, 270)->save(Yii::getAlias('@webroot').$uploadPath, ['quality' => 80]);
      return $uploadPath;
    }
    
    public function textEditorImageResponsive($content) {
        preg_match_all('/<img[^>]+>/i',$content, $result);
        
        if($result[0]){
            $count = count($result[0]);
            for($i=0; $i<$count;$i++){
                preg_match( '@src="([^"]+)"@' , $result[0][$i], $match );
                $src = array_pop($match);
                $content = preg_replace($result[0][$i], 'img src="'.$src.'" class="img-responsive"', $content);
                
            }
        }
        return $content;
        
    }
    
    //create cookie after see topic
    public function updateRead($model) {
        $cookies = Yii::$app->request->cookies;
        $value = substr(Yii::$app->getSecurity()->generateRandomString(),10);

        if (!isset($cookies['memo-v' . $model->id. '-' . Yii::$app->user->id])) {
            
            $model->read += 1;
            if($model->save()){
                $cookies = Yii::$app->response->cookies;
                $cookies->add(new \yii\web\Cookie([
                    'name' => 'memo-v' . $model->id. '-' . Yii::$app->user->id,
                    'value' => $value,
                    //'expire' => 60*60,
                ]));
            }
        }
        
    }
    
    public function actionComment($id) {
        $this->isLogin();
        if($this->checkBanned()){
            return $this->redirect(Yii::$app->seo->getUrl('wonder/banned'));
        }
        $memory = MemoryModel::findOne($id);
        $model = new CommentModel();
        $reply = Yii::$app->request->get('reply');
        $user = Yii::$app->request->get('to');
        if ($model->load(Yii::$app->request->post())) {
            $model->id_user = Yii::$app->user->id;
            $model->id_parent = $reply ? $reply : 0;
            $model->id_cat = $id;
            $model->category = 'memory';
            $model->create_time = date('Y-m-d H:i:s');
            $model->update_time = null;
            $model->create_ip = Yii::$app->request->getUserIP();
            $model->content = $this->textEditorImageResponsive($model->content);
            $model->feeling = 0;
            if($model->save()){
                if($reply){
                    $flag_parent = null;
                    $parent_reply = CommentModel::findOne($reply);
                    if($parent_reply && $parent_reply->id_user != Yii::$app->user->id){
                        NotifyController::creatNotify($parent_reply->id_user, $reply, 'comment', 'comment', null, $this->generateUrlNotifyComment($memory->id, $model->id));
                        $flag_parent = $parent_reply->id_user;
                    }
                    $all_child = CommentModel::find()->select('id_user')->where(['id_parent'=>$reply])->distinct()->all();
                    if($all_child){
                        foreach ($all_child as $row) {
                            if($row->id_user != Yii::$app->user->id && $row->id_user != $flag_parent){
                                NotifyController::creatNotify($row->id_user, $reply, 'comment', 'comment', null, $this->generateUrlNotifyComment($memory->id, $model->id));
                            }
                        }
                    }
                }
                else{
                    if($memory->id_user != Yii::$app->user->id){
                        NotifyController::creatNotify($memory->id_user, $model->id, $model->category, 'comment', null, $this->generateUrlNotifyComment($memory->id, $model->id));
                    }
                }
                ExpController::createLogEXP(Yii::$app->user->id, $model->id, 'comment', 'memory-comment');
                return $this->redirect(Yii::$app->seo->getUrl('memory/view').'/'.$id);
            }
        } else {
            return $this->render('_comment', [
                'model' => $model,
                'memory' => $memory,
            ]);
        }
    }
    public function actionEditcomment($id) {
        $this->isLogin();
        if($this->checkBanned()){
            return $this->redirect(Yii::$app->seo->getUrl('wonder/banned'));
        }
        $model = CommentModel::findOne($id);
        $memory = MemoryModel::findOne($model->id_cat);
        
        /********** check permission edit **********/
        if(!$this->checkPermission($model->id_user)){
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        
        if ($model->load(Yii::$app->request->post())) {
            $model->content = $this->textEditorImageResponsive($model->content);
            $model->update_time = date('Y-m-d H:i:s');
            if($model->save()){
                return $this->redirect(Yii::$app->seo->getUrl('memory/view').'/'.$model->id_cat);
            }
        } else {
            return $this->render('_comment', [
                'model' => $model,
                'memory' => $memory,
            ]);
        }
    }
    
    public function generateUrlNotifyComment($memory, $comment) {
        $url = '/memory/view/' . $memory . '#data-comment-' . $comment;
        return $url;
    }
    
}