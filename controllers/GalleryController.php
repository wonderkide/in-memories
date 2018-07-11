<?php

namespace app\controllers;

use Yii;
use app\components\MyController;
use yii\filters\VerbFilter;

use yii\web\UploadedFile;
use app\models\GalleryModel;
use app\models\GalleryImagesModel;
use app\models\UserModel;
use yii\helpers\BaseFileHelper;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\web\NotFoundHttpException;
use app\models\CommentModel;
use app\models\ContentModel;
use yii\data\Pagination;
use yii\imagine\Image;

class GalleryController extends MyController
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }
    public function beforeAction($action)
    {
        /*if (\Yii::$app->user->isGuest){
            return $this->redirect('/site/login');
        }*/
        $this->enableCsrfValidation = false;
        
        return parent::beforeAction($action);
    }


    public function actionIndex()
    {
        $get_all = 1;
        $get_me = 1;
        $search = null;
        
        if (Yii::$app->request->get('search')) {
            $search = Yii::$app->request->get('search');
        }

        if (Yii::$app->request->get('gallery_all')) {
            $get_all = Yii::$app->request->get('gallery_all');
        }
        if (Yii::$app->request->get('gallery_me')) {
            $get_me = Yii::$app->request->get('gallery_me');
        }
        
        if($get_all==1 && $get_me==1){
            $gallery = GalleryModel::find()->where(['show'=>1, 'banned'=>0])->andFilterWhere(['like', 'name', $search])->orderBy(['create_date'=>SORT_DESC])->all();
        }
        else if($get_me==1 && $get_all!=1 && !Yii::$app->user->isGuest){
            $gallery = GalleryModel::find()->where(['id_user'=>Yii::$app->user->id])->andFilterWhere(['like', 'name', $search])->orderBy(['create_date'=>SORT_DESC])->all();
            
        }
        else if($get_me!=1 && $get_all==1){
            if(!Yii::$app->user->isGuest){
                $gallery = GalleryModel::find()->where(['show'=>1, 'banned'=>0])->andWhere(['!=', 'id_user', Yii::$app->user->id])->andFilterWhere(['like', 'name', $search])->orderBy(['create_date'=>SORT_DESC])->all();
            }
            else{
                $gallery = GalleryModel::find()->where(['show'=>1, 'banned'=>0])->andFilterWhere(['like', 'name', $search])->orderBy(['create_date'=>SORT_DESC])->all();
            }
            
            
        }
        else{
            $gallery = null;
        }
        return $this->render('index', [
            'gallery' => $gallery,
            'get_all' => $get_all,
            'get_me' => $get_me,
            'search' => $search,
        ]);
    }
    

    public function actionView($slug)
    {
        $gallery = GalleryModel::find()->where(['ref' => $slug])->one();
        if($gallery->id_user != Yii::$app->user->id){
            $gallery = GalleryModel::find()->where(['ref' => $slug,'show' => 1,'banned' => 0])->one();
            if(!$gallery){
                $content = ContentModel::findOne(['type'=>'no-data']);
                return $this->render('no-data', [
                    'content' => $content,
                ]);
            }
            $this->updateRead($gallery);
        }
        \Yii::$app->view->title = 'อัลบั้ม :: ' . $gallery->name;
        
        $imageModel = GalleryImagesModel::findAll(['ref' => $slug]);
        $user = UserModel::findOne($gallery->id_user);
        
        $comment = CommentModel::find()->where(['id_parent'=>0, 'id_cat'=>$gallery->id, 'category'=>'gallery'])->orderBy(['create_time'=>SORT_ASC]);
        $count = $comment->count();
        // create a pagination object with the total count
        $pagination = new Pagination(['totalCount' => $count, 'pageSize' => 20]);

        // limit the query using the pagination and retrieve the articles
        $comments = $comment->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();
        $top_comment = CommentModel::find()->where(['id_parent'=>0, 'banned'=>0, 'id_cat'=>$gallery->id, 'category'=>'gallery'])->andWhere(['>', 'feeling', 0])->limit(3)->orderBy(['feeling'=>SORT_DESC])->all();
        return $this->render('view', [
            'imageModel' => $imageModel,
            'gallery' => $gallery,
            'user' => $user,
            'comment' => $comments,
            'top_comment' => $top_comment,
            'pages' => $pagination,
        ]);
    }
    
    /********************** Delete gallery and image all **********************/
    public function actionDelete() {
        $this->isLogin();
        $ref = Yii::$app->request->get('id');
        $model = GalleryModel::findOne(['ref'=>$ref]);
        
        if(!$model || !$this->checkPermission($model->id_user)){
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        $images = GalleryImagesModel::findAll(['ref'=>$ref]);
        if($images){
            foreach ($images as $image) {
                $this->deleteImageAllGallery($image);
            }
        }
        if($model->delete()){
            return TRUE;
        }
        return FALSE;
    }
    public function deleteImageAllGallery($image) {
        $filename  = GalleryModel::getUploadPath().$image->ref.'/'.$image->real_name;
        $thumbnail = GalleryModel::getUploadPath().$image->ref.'/thumbnail/'.$image->real_name;
        if($image->delete()){
            @unlink($filename);
            @unlink($thumbnail);
            return true;
        }else{
            return FALSE;
        }
    }
    /******************************* End delete gallery ************************************/
    
    public function actionAdd() {
        $this->isLogin();
        $check = null;
        if(Yii::$app->request->get('album')){
            $check = Yii::$app->request->get('album');
        }
        $active = null;
        if(Yii::$app->request->get('active')){
            $active = Yii::$app->request->get('active');
        }
        $uploaded = null;
        if(Yii::$app->request->get('uploaded')){
            $uploaded = Yii::$app->request->get('uploaded');
            //var_dump($finish);exit();
        }
        $initialPreview = null;
        $initialPreviewConfig = null;
        if($check){
            //$model = $this->findModel($check);
            $model = GalleryModel::findOne(['ref'=>$check]);
            if($model){
                if(!$this->checkPermission($model->id_user)){
                    throw new NotFoundHttpException('The requested page does not exist.');

                }
                if($model->load(Yii::$app->request->post())){
                    $this->Uploads(false);
                    $model->update_date = date('Y-m-d H:i:s');
                    if($model->save()){
                        return $this->redirect([Yii::$app->seo->getUrl('gallery/add').'?album=' . $model->ref.'&active=gallery']);
                    }
                }

                list($initialPreview,$initialPreviewConfig) = $this->getInitialPreview($model->ref);
            }
            else{
                throw new NotFoundHttpException('The requested page does not exist.');
            }
        }
        else{
            if($this->checkBanned()){
                return $this->redirect(Yii::$app->seo->getUrl('wonder/banned'));
            }
            $model = new GalleryModel();

            if ($model->load(Yii::$app->request->post()) ) {
                $model->id_user = Yii::$app->user->id;
                $model->create_date = date("Y-m-d");
                $model->read = 0;
                
                $this->Uploads(false);

                if($model->save()){
                    ExpController::createLogEXP(Yii::$app->user->id, $model->id, 'gallery', 'create gallery');
                     return $this->redirect([Yii::$app->seo->getUrl('gallery/add').'?album=' . $model->ref.'&active=uploaded']);
                }

            } else {
                $model->ref = substr(Yii::$app->getSecurity()->generateRandomString(),10);
            }
        }
        return $this->render('add', [
            'model' => $model,
            'initialPreview'=>$initialPreview,
            'initialPreviewConfig'=>$initialPreviewConfig,
            'gallery' => $check,
            'active' => $active,
            'uploaded' => $uploaded,
        ]);
    }
    public function actionManage($album)
    {
        //var_dump($album);exit();
        /*$this->isLogin();
        $check = null;
        if(Yii::$app->request->get('album')){
            $check = Yii::$app->request->get('album');
        }*/
        $active = null;
        if(Yii::$app->request->get('active')){
            $active = Yii::$app->request->get('active');
        }
        $initialPreview = null;
        $initialPreviewConfig = null;
        
        if($album){
            //$model = $this->findModel($check);
            $model = GalleryModel::findOne(['ref'=>$album]);
            if($model){
                if(!$this->checkPermission($model->id_user)){
                    throw new NotFoundHttpException('The requested page does not exist.');

                }
                if($model->load(Yii::$app->request->post())){
                    $this->Uploads(false);
                    $model->update_date = date('Y-m-d H:i:s');
                    if($model->save()){
                        return $this->redirect([Yii::$app->seo->getUrl('gallery/manage').'/' . $model->ref]);
                    }
                }

                list($initialPreview,$initialPreviewConfig) = $this->getInitialPreview($model->ref);
            }
            else{
                throw new NotFoundHttpException('The requested page does not exist.');
            }
        }
        else{
            if($this->checkBanned()){
                return $this->redirect(Yii::$app->seo->getUrl('wonder/banned'));
            }
            $model = new GalleryModel();

            if ($model->load(Yii::$app->request->post()) ) {
                $model->id_user = Yii::$app->user->id;
                $model->create_date = date("Y-m-d");
                $model->read = 0;
                
                $this->Uploads(false);

                if($model->save()){
                    ExpController::createLogEXP(Yii::$app->user->id, $model->id, 'gallery', 'create gallery');
                     return $this->redirect([Yii::$app->seo->getUrl('gallery/manage').'/' . $model->ref]);
                }

            } else {
                $model->ref = substr(Yii::$app->getSecurity()->generateRandomString(),10);
            }
        }
        return $this->render('manage', [
            'model' => $model,
            'initialPreview'=>$initialPreview,
            'initialPreviewConfig'=>$initialPreviewConfig,
            'gallery' => $album,
            'active' => $active,
        ]);
    }
    
    protected function findModel($id)
    {
        if (($model = GalleryModel::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    /*|*********************************************************************************|
  |================================ Upload Ajax ====================================|
  |*********************************************************************************|*/

    public function actionUploadAjax(){
           $this->Uploads(true);
     }

    private function CreateDir($folderName){
        if($folderName != NULL){
            $basePath = GalleryModel::getUploadPath();
            if(BaseFileHelper::createDirectory($basePath.$folderName,0777)){
                BaseFileHelper::createDirectory($basePath.$folderName.'/thumbnail',0777);
            }
        }
        return;
    }

    private function removeUploadDir($dir){
        BaseFileHelper::removeDirectory(GalleryModel::getUploadPath().$dir);
    }

    private function Uploads($isAjax=false) {
             if (Yii::$app->request->isPost) {
                $images = UploadedFile::getInstancesByName('upload_ajax');
                if ($images) {

                    if($isAjax===true){
                        $ref =Yii::$app->request->post('ref');
                        $model_id = Yii::$app->request->post('id');
                    }else{
                        $PhotoLibrary = Yii::$app->request->post('GalleryModel');
                        $ref = $PhotoLibrary['ref'];
                    }

                    $this->CreateDir($ref);

                    foreach ($images as $file){
                        $fileName       = $file->baseName . '.' . $file->extension;
                        $realFileName   = md5($file->baseName.time()) . '.' . $file->extension;
                        $savePath       = GalleryModel::UPLOAD_FOLDER.'/'.Yii::$app->user->id.'/'.$ref.'/'. $realFileName;
                        if($file->saveAs($savePath)){

                            if($this->isImage(Url::base(true).'/'.$savePath)){
                                 $this->createThumbnail($ref,$realFileName);
                            }

                            $model                  = new GalleryImagesModel();
                            $model->id_gallery      = $model_id;
                            $model->ref             = $ref;
                            $model->title           = '';
                            $model->detail          = '';
                            $model->file_name       = $fileName;
                            $model->real_name       = $realFileName;
                            $model->path            = '/'.GalleryModel::UPLOAD_FOLDER.'/'.Yii::$app->user->id.'/'.$ref.'/';
                            $model->sorting         = $this->getSorting($ref);
                            $model->save();

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

    private function getInitialPreview($ref) {
            $datas = GalleryImagesModel::find()->where(['ref'=>$ref])->orderBy(['sorting'=>SORT_ASC])->all();
            $initialPreview = [];
            $initialPreviewConfig = [];
            foreach ($datas as $key => $value) {
                array_push($initialPreview, $this->getTemplatePreview($value));
                array_push($initialPreviewConfig, [
                    'caption'=> "<label>".$value->file_name."</label>",
                    'width'  => '120px',
                    'url'    => Url::to(['/gallery/deletefile-ajax']),
                    'key'    => $value->id,
                    'showDrag' => false,
                ]);
            }
            return  [$initialPreview,$initialPreviewConfig];
    }

    public function isImage($filePath){
            return @is_array(getimagesize($filePath)) ? true : false;
    }

    private function getTemplatePreview(GalleryImagesModel $model){
            $filePath = GalleryModel::getUploadUrl().$model->ref.'/thumbnail/'.$model->real_name;
            $isImage  = $this->isImage($filePath);
            if($isImage){
                $file = Html::img($filePath,['class'=>'file-preview-image', 'alt'=>$model->file_name, 'title'=>$model->file_name]);
            }else{
                $file =  "<div class='file-preview-other'> " .
                         "<h2><i class='glyphicon glyphicon-file'></i></h2>" .
                         "</div>";
            }
            return $file;
    }

    private function createThumbnail($folderName,$fileName){
      $uploadPath   = GalleryModel::getUploadPath().'/'.$folderName.'/';
      $file         = $uploadPath.$fileName;
      //$image        = Yii::$app->image->load($file);
      //$image->resize($width);
      //$image->save($uploadPath.'thumbnail/'.$fileName);
      //Image::getImagine()->open($file)->thumbnail(new Box($width, $width))->save($uploadPath.'thumbnail/'.$fileName , ['quality' => 90]);
      Image::thumbnail($file, 370, 270)->save(Yii::getAlias($uploadPath.'thumbnail/'.$fileName), ['quality' => 80]);
      return;
    }

    public function actionDeletefileAjax(){

        $model = GalleryImagesModel::findOne(Yii::$app->request->post('key'));
        if($model!==NULL){
            $filename  = GalleryModel::getUploadPath().$model->ref.'/'.$model->real_name;
            $thumbnail = GalleryModel::getUploadPath().$model->ref.'/thumbnail/'.$model->real_name;
            if($model->delete()){
                @unlink($filename);
                @unlink($thumbnail);
                echo json_encode(['success'=>true]);
            }else{
                echo json_encode(['success'=>false]);
            }
        }else{
          echo json_encode(['success'=>false]);  
        }
    }
/*************************** End ajax upload ***************************/
    
    
    public function actionUpdatesort() {
        if(Yii::$app->request->post() && isset(Yii::$app->request->post()['data'])){
            $data = Yii::$app->request->post()['data'];

            $newsort = explode(",",$data);

            $sort = 1;
            foreach ($newsort as $value) {
                $model = GalleryImagesModel::findOne($value);
                $model->sorting = $sort;
                if($model->save()){
                    $sort++;
                }
            }
            return 1;
        }
        return 0;
    }
    
    public function actionSortable(){
        if(!Yii::$app->request->get('data-selected') || !Yii::$app->request->get('sort')){
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        $id = Yii::$app->request->get('data-selected');
        $action = Yii::$app->request->get('sort');
        
        $model = GalleryImagesModel::findOne($id);
        $sort = $model->sorting;
        $image = GalleryModel::findOne($model->id_gallery);
        
        if(!$model || !$this->checkPermission($image->id_user)){
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        $condition = ['>', 'sorting', $sort];
        $orderBy = ['sorting' => SORT_ASC];


        if ($action == 'up') {
            $condition = ['<', 'sorting', $sort];
            $orderBy = ['sorting' => SORT_DESC];
        }


        $nextModel = GalleryImagesModel::find()->where($condition)->andWhere(['id_gallery'=>$model->id_gallery])->orderBy($orderBy)->one();

        if (!empty($model) && !empty($nextModel)) {
            $model->sorting = $nextModel->sorting;
            $nextModel->sorting = $sort;
            $nextModel->update();
            $model->update();
        }
        if(Yii::$app->request->get('add')){
            return $this->redirect([Yii::$app->seo->getUrl('gallery/add').'?album='.$model->ref.'&active=sort']);
        }else{
            return $this->redirect([Yii::$app->seo->getUrl('gallery/manage').'/'.$model->ref.'?active=sort']);
        }
    }


    public function getSorting($ref) {
        $model = GalleryImagesModel::find()->where(['ref' => $ref])->orderBy(['sorting'=>SORT_DESC])->one();
        if($model){
            return $model->sorting+1;
        }
        return 1;
    }
    
    public function actionGetimage() {
        if(Yii::$app->request->post() && isset(Yii::$app->request->post()['selected'])){
            $data = Yii::$app->request->post()['selected'];
            $model = GalleryImagesModel::findOne($data);
            return $model->id.','.$model->title.','.$model->detail;
        }
        return 0;
    }
    
    public function actionUpdatecaption() {
        if(Yii::$app->request->post() && isset(Yii::$app->request->post()['selected'])){
            $selected = Yii::$app->request->post()['selected'];
            $title = Yii::$app->request->post()['title'];
            $detail = Yii::$app->request->post()['detail'];
            
            $model = GalleryImagesModel::findOne($selected);
            $image = GalleryModel::findOne($model->id_gallery);
            if($model && $this->checkPermission($image->id_user)){
                $model->title = $title;
                $model->detail = $detail;
                if($model->save()){
                    return 1;
                }
            }
        }
        return 0;
    }
    
    public function actionPersonal() {
        $this->isLogin();
        $gallery = GalleryModel::find()->where(['id_user'=>Yii::$app->user->id])->orderBy(['create_date'=>SORT_DESC])->all();
        return $this->render('personal', [
            'gallery' => $gallery,
        ]);
    }
    
    public function actionComment($id) {
        $this->isLogin();
        if($this->checkBanned()){
            return $this->redirect(Yii::$app->seo->getUrl('wonder/banned'));
        }
        $gallery = GalleryModel::findOne($id);
        $model = new CommentModel();
        $reply = Yii::$app->request->get('reply');
        $user = Yii::$app->request->get('to');
        if ($model->load(Yii::$app->request->post())) {
            $model->id_user = Yii::$app->user->id;
            $model->id_parent = $reply ? $reply : 0;
            $model->id_cat = $id;
            $model->category = 'gallery';
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
                        NotifyController::creatNotify($parent_reply->id_user, $reply, 'comment', 'comment', null, $this->generateUrlNotifyComment($gallery->ref, $model->id));
                        $flag_parent = $parent_reply->id_user;
                    }
                    $all_child = CommentModel::find()->select('id_user')->where(['id_parent'=>$reply])->distinct()->all();
                    if($all_child){
                        foreach ($all_child as $row) {
                            if($row->id_user != Yii::$app->user->id && $row->id_user != $flag_parent){
                                NotifyController::creatNotify($row->id_user, $reply, 'comment', 'comment', null, $this->generateUrlNotifyComment($gallery->ref, $model->id));
                            }
                        }
                    }
                }
                else{
                    if($gallery->id_user != Yii::$app->user->id){
                        NotifyController::creatNotify($gallery->id_user, $model->id, $model->category, 'comment', null, $this->generateUrlNotifyComment($gallery->ref, $model->id));
                    }
                }
                ExpController::createLogEXP(Yii::$app->user->id, $model->id, 'comment', 'gallery-comment');
                return $this->redirect(Yii::$app->seo->getUrl('gallery/view').'/'.$gallery->ref);
            }
        } else {
            return $this->render('_comment', [
                'model' => $model,
                'gallery' => $gallery,
            ]);
        }
    }
    public function actionEditcomment($id) {
        $this->isLogin();
        if($this->checkBanned()){
            return $this->redirect(Yii::$app->seo->getUrl('wonder/banned'));
        }
        $model = CommentModel::findOne($id);
        $gallery = GalleryModel::findOne($model->id_cat);
        
        /********** check permission edit **********/
        if(!$this->checkPermission($model->id_user)){
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        
        if ($model->load(Yii::$app->request->post())) {
            $model->content = $this->textEditorImageResponsive($model->content);
            $model->update_time = date('Y-m-d H:i:s');
            if($model->save()){
                return $this->redirect(Yii::$app->seo->getUrl('gallery/view').'/'.$gallery->ref);
            }
        } else {
            return $this->render('_comment', [
                'model' => $model,
                'gallery' => $gallery,
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
    
    public function generateUrlNotifyComment($gallery, $ref) {
        $url = '/gallery/view/' . $gallery . '#data-comment-' . $ref;
        return $url;
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

}