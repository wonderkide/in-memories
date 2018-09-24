<?php

namespace app\controllers;

use Yii;
use app\models\VideoModel;
use app\models\VideoSearchModel;
use app\components\MyController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\CommentModel;
use app\models\ContentModel;
use app\models\UserModel;
use yii\data\Pagination;
use app\models\VideoItemModel;
use yii\web\UploadedFile;
use yii\helpers\BaseFileHelper;
use yii\helpers\Url;

/**
 * VideoController implements the CRUD actions for VideoModel model.
 */
class VideoController extends MyController
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
     * Lists all VideoModel models.
     * @return mixed
     */
    public function actionIndex()
    {
        //$searchModel = new VideoSearchModel();
        //$dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            //'searchModel' => $searchModel,
            //'dataProvider' => $dataProvider,
        ]);
    }
    
    public function actionManage() {
        $this->isLogin();
        $searchModel = new VideoSearchModel();
        $dataProvider = $searchModel->searchByUser(Yii::$app->request->queryParams);
        return $this->render('manage', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single VideoModel model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = VideoModel::find()->where(['id'=>$id, 'banned'=>0, 'show'=>1])->one();
        if(!$model){
            $content = ContentModel::findOne(['type'=>'no-data']);
            return $this->render('no-data', [
                'content' => $content,
            ]);
        }
        $items = VideoItemModel::find()->where(['id_video'=>$id])->orderBy(['sorting'=>SORT_ASC])->all();
        \Yii::$app->view->title = 'วีดีโอ :: ' . $model->name;
        
        $user = UserModel::findOne($model->id_user);

        $comment = CommentModel::find()->where(['id_parent'=>0, 'id_cat'=>$model->id, 'category'=>'video'])->orderBy(['create_time'=>SORT_ASC]);
        $count = $comment->count();
        // create a pagination object with the total count
        $pagination = new Pagination(['totalCount' => $count, 'pageSize' => 20]);

        // limit the query using the pagination and retrieve the articles
        $comments = $comment->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();
        $top_comment = CommentModel::find()->where(['id_parent'=>0, 'banned'=>0, 'id_cat'=>$model->id, 'category'=>'video'])->andWhere(['>', 'feeling', 0])->limit(3)->orderBy(['feeling'=>SORT_DESC])->all();
        if($model->id_user != Yii::$app->user->id){
            $this->updateRead($model);
        }
        return $this->render('view_fp', [
            'model' => $model,
            'items' => $items,
            'user' => $user,
            'comment' => $comments,
            'top_comment' => $top_comment,
            'pages' => $pagination,
        ]);
    }

    /**
     * Creates a new VideoModel model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $this->isLogin();
        if($this->checkBanned()){
            return $this->redirect(Yii::$app->seo->getUrl('wonder/banned'));
        }
        $model = new VideoModel();

        if ($model->load(Yii::$app->request->post())) {
            $model->id_user = Yii::$app->user->id;
            $model->create_date = date('Y-m-d H:i:s');
            $model->read = 0;
            if($model->save()){
                ExpController::createLogEXP(Yii::$app->user->id, $model->id, 'video', 'create video group');
                return $this->redirect([Yii::$app->seo->getUrl('video/manage')]);
            }
            return $this->redirect(['manage']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }
    
    public function actionItem($id){
        $this->isLogin();
        $active = null;
        if(Yii::$app->request->get('active')){
            $active = Yii::$app->request->get('active');
        }

        $initialPreview = null;
        $initialPreviewConfig = null;
        $items = null;
        
        $model = $this->findModel($id);
        if($model){
            list($initialPreview,$initialPreviewConfig) = $this->getInitialPreview($model->id);
            $items = VideoItemModel::find()->where(['id_video'=>$id])->orderBy(['sorting'=>SORT_ASC])->all();
        }
        if(!$this->checkPermission($model->id_user)){
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        
        return $this->render('_item', [
            'model' => $model,
            'initialPreview'=>$initialPreview,
            'initialPreviewConfig'=>$initialPreviewConfig,
            'items' => $items,
            'active' => $active,
        ]);
    }

    /**
     * Updates an existing VideoModel model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if(!$this->checkPermission($model->id_user)){
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['manage']);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing VideoModel model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->isLogin();
        $model = $this->findModel($id);
        if(!$model || !$this->checkPermission($model->id_user)){
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        $video = VideoItemModel::findAll(['id_video'=>$model->id]);
        if($video){
            foreach ($video as $item) {
                $this->deleteVideoAll($item);
            }
        }
        $model->delete();

        return $this->redirect(['manage']);
    }
    
    private function deleteVideoAll($item){
        $file  = $_SERVER["DOCUMENT_ROOT"].$item->path;
        $thumbnail = $_SERVER["DOCUMENT_ROOT"].$item->thumbnail;
        if($item->path){
            @unlink($file);
            if($item->thumbnail){
                @unlink($thumbnail);
            }
            return true;
        }else{
            return FALSE;
        }
    }

    /**
     * Finds the VideoModel model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return VideoModel the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = VideoModel::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    //create cookie after see topic
    public function updateRead($model) {
        $cookies = Yii::$app->request->cookies;
        $value = substr(Yii::$app->getSecurity()->generateRandomString(),10);

        if (!isset($cookies['gallery-v' . $model->id . '-' . Yii::$app->user->id])) {
            
            $model->read += 1;
            if($model->save()){
                $cookies = Yii::$app->response->cookies;
                $cookies->add(new \yii\web\Cookie([
                    'name' => 'gallery-v' . $model->id. '-' . Yii::$app->user->id,
                    'value' => $value,
                    //'expire' => 60*60,
                ]));
            }
        }
        
    }
    
    public function actionDeletefileAjax(){

        $model = VideoItemModel::findOne(Yii::$app->request->post('key'));
        if($model!==NULL){
            $filename  = $_SERVER["DOCUMENT_ROOT"].$model->path;
            $thumbnail = null;
            if($model->thumbnail){
                $thumbnail  = $_SERVER["DOCUMENT_ROOT"].$model->thumbnail;
            }
            if($model->delete()){
                @unlink($filename);
                if($thumbnail){
                    @unlink($thumbnail);
                }
                echo json_encode(['success'=>true]);
            }else{
                echo json_encode(['success'=>false]);
            }
        }else{
          echo json_encode(['success'=>false]);
        }
    }
    
    private function getInitialPreview($id) {
            $datas = VideoItemModel::find()->where(['id_video'=>$id])->orderBy(['sorting'=>SORT_ASC])->all();
            $initialPreview = [];
            $initialPreviewConfig = [];
            foreach ($datas as $key => $value) {
                array_push($initialPreview, $this->getTemplatePreview($value));
                array_push($initialPreviewConfig, [
                    'caption'=> "<label>".$value->title."</label>",
                    'width'  => '120px',
                    'url'    => Url::to(['/video/deletefile-ajax']),
                    'key'    => $value->id,
                    'showDrag' => false,
                ]);
            }
            return  [$initialPreview,$initialPreviewConfig];
    }
    
    private function getTemplatePreview(VideoItemModel $model){
            if($model){
                $thumb = null;
                if($model->thumbnail){
                    $thumb = 'poster="'.$model->thumbnail.'"';
                }
                $file = '<video id="video-'.$model->id.'" class="kv-preview-data" '.$thumb.'  controls><source src="'. $model->path .'" type="video/mp4"></video>' ;
            }else{
                $file =  "<div class='file-preview-other'> " .
                         "<h2><i class='glyphicon glyphicon-file'></i></h2>" .
                         "</div>";
            }
            return $file;
    }
    
    public function actionUploadAjax(){
           $this->Uploads(true);
    }
    
    private function CreateDir(){
        $basePath = VideoModel::getUploadPath();
        if(BaseFileHelper::createDirectory($basePath,0777)){
            BaseFileHelper::createDirectory($basePath.'/thumbnail',0777);
        }
        return;
    }
    
    private function Uploads($isAjax=false) {
             if (Yii::$app->request->isPost) {
                $images = UploadedFile::getInstancesByName('upload_ajax');
                if ($images) {

                    if($isAjax===true){
                        $model_id = Yii::$app->request->post('id');
                    }

                    $this->CreateDir();

                    foreach ($images as $file){
                        $fileName       = $file->baseName . '.' . $file->extension;
                        $realFileName   = md5($file->baseName.time()) . '_' . $fileName;
                        $savePath       = VideoModel::UPLOAD_FOLDER.'/'.Yii::$app->user->id.'/'. $realFileName;
                        if($file->saveAs($savePath)){
                            
                            $model = new VideoItemModel();
                            $model->id_video = $model_id;
                            $model->path = '/'.$savePath;
                            $model->sorting = $this->getSorting($model_id);

                            if($model->save()){
                                //$thumbPath = VideoModel::UPLOAD_FOLDER.'/'.Yii::$app->user->id.'/thumbnail/';
                                //$this->getThumbVideo($savePath,$thumbPath);
                            }

                            if($isAjax===true){
                                echo json_encode(['success' => 'true']);
                            }

                        }else{
                            if($isAjax===true){
                                echo json_encode(['success'=>'false','eror'=>$file->error]);
                            }
                        }

                    }
                }
            }
    }
    
    public function getSorting($id) {
        $model = VideoItemModel::find()->where(['id_video' => $id])->orderBy(['sorting'=>SORT_DESC])->one();
        if($model){
            return $model->sorting+1;
        }
        return 1;
    }
    
    public function actionSortable(){
        if(!Yii::$app->request->get('data-selected') || !Yii::$app->request->get('sort')){
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        $id = Yii::$app->request->get('data-selected');
        $action = Yii::$app->request->get('sort');
        
        $model = VideoItemModel::findOne($id);
        $sort = $model->sorting;
        $video = VideoModel::findOne($model->id_video);
        
        if(!$model || !$this->checkPermission($video->id_user)){
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        $condition = ['>', 'sorting', $sort];
        $orderBy = ['sorting' => SORT_ASC];


        if ($action == 'up') {
            $condition = ['<', 'sorting', $sort];
            $orderBy = ['sorting' => SORT_DESC];
        }


        $nextModel = VideoItemModel::find()->where($condition)->andWhere(['id_video'=>$model->id_video])->orderBy($orderBy)->one();

        if (!empty($model) && !empty($nextModel)) {
            $model->sorting = $nextModel->sorting;
            $nextModel->sorting = $sort;
            $nextModel->update();
            $model->update();
        }
        
        return $this->redirect([Yii::$app->seo->getUrl('video/item').'/'.$model->id_video.'?active=sort']);
    }
    
    public function actionGetcaption() {
        if(Yii::$app->request->post() && isset(Yii::$app->request->post()['selected'])){
            $data = Yii::$app->request->post()['selected'];
            $model = VideoItemModel::findOne($data);
            return $model->id.','.$model->title.','.$model->detail;
        }
        return 0;
    }
    
    public function actionUpdatecaption() {
        if(Yii::$app->request->post() && isset(Yii::$app->request->post()['selected'])){
            $selected = Yii::$app->request->post()['selected'];
            $title = Yii::$app->request->post()['title'];
            $detail = Yii::$app->request->post()['detail'];
            
            $model = VideoItemModel::findOne($selected);
            $video = VideoModel::findOne($model->id_video);
            if($model && $this->checkPermission($video->id_user)){
                $model->title = $title;
                $model->detail = $detail;
                if($model->save()){
                    return 1;
                }
            }
        }
        return 0;
    }
    
    public function actionUpdatesort() {
        if(Yii::$app->request->post() && isset(Yii::$app->request->post()['data'])){
            $data = Yii::$app->request->post()['data'];

            $newsort = explode(",",$data);

            $sort = 1;
            foreach ($newsort as $value) {
                $model = VideoItemModel::findOne($value);
                $model->sorting = $sort;
                if($model->save()){
                    $sort++;
                }
            }
            return 1;
        }
        return 0;
    }
    
    public function actionUploadThumbnail(){
        if(Yii::$app->request->post()){
            $thumbs_dir = '/uploads/video/';
            if(isset($_POST['item']) && isset($_POST['content'])){
                $data = $_POST['content'];
                $id = $_POST['item'];
                if (preg_match('/^data:image\/(\w+);base64,/', $data, $type)) {
                    $data = substr($data, strpos($data, ',') + 1);
                    $type = strtolower($type[1]); // jpg, png, gif

                    if (!in_array($type, [ 'jpg', 'jpeg', 'gif', 'png' ])) {
                        //throw new \Exception('invalid image type');
                        return 0;
                    }

                    $data = base64_decode($data);

                    if ($data === false) {
                        //throw new \Exception('base64_decode failed');
                        return 0;
                    }
                } else {
                    //throw new \Exception('did not match data URI with image data');
                    return 0;
                }
                $prefix = md5(date('Y-m-d').$id);
                $thumbPath = VideoModel::UPLOAD_FOLDER.'/'.Yii::$app->user->id.'/thumbnail/' . $prefix;
                
                $path = '/'.$thumbPath . '_thumbnail.' . $type;

                file_put_contents("{$thumbPath}_thumbnail.{$type}", $data);
                
                $cut_id = str_replace('video-', '', $id);
                $model = VideoItemModel::findOne($cut_id);
                if($model){
                    $model->thumbnail = $path;
                    if($model->save()){
                        return 1;
                    }
                }
            }
            
        }
        return 0;
    }
    
    public function actionComment($id) {
        $this->isLogin();
        if($this->checkBanned()){
            return $this->redirect(Yii::$app->seo->getUrl('wonder/banned'));
        }
        $video = $this->findModel($id);
        $model = new CommentModel();
        $reply = Yii::$app->request->get('reply');
        $user = Yii::$app->request->get('to');
        if ($model->load(Yii::$app->request->post())) {
            $model->id_user = Yii::$app->user->id;
            $model->id_parent = $reply ? $reply : 0;
            $model->id_cat = $id;
            $model->category = 'video';
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
                        NotifyController::creatNotify($parent_reply->id_user, $reply, 'comment', 'comment', null, $this->generateUrlNotifyComment($video->id, $model->id));
                        $flag_parent = $parent_reply->id_user;
                    }
                    $all_child = CommentModel::find()->select('id_user')->where(['id_parent'=>$reply])->distinct()->all();
                    if($all_child){
                        foreach ($all_child as $row) {
                            if($row->id_user != Yii::$app->user->id && $row->id_user != $flag_parent){
                                NotifyController::creatNotify($row->id_user, $reply, 'comment', 'comment', null, $this->generateUrlNotifyComment($video->id, $model->id));
                            }
                        }
                    }
                }
                else{
                    if($video->id_user != Yii::$app->user->id){
                        NotifyController::creatNotify($video->id_user, $model->id, $model->category, 'comment', null, $this->generateUrlNotifyComment($video->id, $model->id));
                    }
                }
                ExpController::createLogEXP(Yii::$app->user->id, $model->id, 'comment', 'video-comment');
                return $this->redirect(Yii::$app->seo->getUrl('video/view').'/'.$video->id);
            }
        } else {
            return $this->render('_comment', [
                'model' => $model,
                'video' => $video,
            ]);
        }
    }
    public function actionEditcomment($id) {
        
        $this->isLogin();
        if($this->checkBanned()){
            return $this->redirect(Yii::$app->seo->getUrl('wonder/banned'));
        }
        
        $model = CommentModel::findOne($id);
        $video = $this->findModel($model->id_cat);
        
        /********** check permission edit **********/
        
        if(!$this->checkPermission($model->id_user)){
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        
        
        if ($model->load(Yii::$app->request->post())) {
            $model->content = $this->textEditorImageResponsive($model->content);
            $model->update_time = date('Y-m-d H:i:s');
            if($model->save()){
                return $this->redirect(Yii::$app->seo->getUrl('video/view').'/'.$video->id);
            }
        } else {
            return $this->render('_comment', [
                'model' => $model,
                'video' => $video,
            ]);
        }
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
    
    public function generateUrlNotifyComment($video, $id) {
        $url = '/video/view/' . $video . '#data-comment-' . $id;
        return $url;
    }
    
}