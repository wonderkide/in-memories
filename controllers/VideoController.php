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
use yii\data\Pagination;
use yii\imagine\Image;
use app\models\VideoItemModel;
use app\models\VideoitemSearchModel;

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
        $searchModel = new VideoSearchModel();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    public function actionManage() {
        $this->isLogin();
        $searchModel = new VideoSearchModel();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
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
        $username = \app\models\UserModel::getName($model->id_user);
        \Yii::$app->view->title = $model->title;
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
        return $this->render('view', [
            'model' => $model,
            'username' => $username,
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
        $model = $this->findModel($id);
        $item = VideoItemModel::find()->where(['id_video'=>$id])->one();
        //var_dump($item);exit();
        if ($model->load(Yii::$app->request->post())) {
            $model->id_user = Yii::$app->user->id;
            $model->create_time = date('Y-m-d H:i:s');
            $model->read = 0;
            if($model->save()){
                ExpController::createLogEXP(Yii::$app->user->id, $model->id, 'video', 'add video');
                return $this->redirect([Yii::$app->seo->getUrl('video/item/'+$id)]);
            }
            return $this->redirect(['manage']);
        } else {
            return $this->render('_item', [
                'model' => $model,
                'item' => $item,
            ]);
        }
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
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
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
    
    public function actionImageUpload()
    {
        $model = new WhateverYourModel();

        $imageFile = UploadedFile::getInstance($model, 'image');

        $directory = Yii::getAlias('@frontend/web/img/temp') . DIRECTORY_SEPARATOR . Yii::$app->session->id . DIRECTORY_SEPARATOR;
        if (!is_dir($directory)) {
            FileHelper::createDirectory($directory);
        }

        if ($imageFile) {
            $uid = uniqid(time(), true);
            $fileName = $uid . '.' . $imageFile->extension;
            $filePath = $directory . $fileName;
            if ($imageFile->saveAs($filePath)) {
                $path = '/img/temp/' . Yii::$app->session->id . DIRECTORY_SEPARATOR . $fileName;
                return Json::encode([
                    'files' => [
                        [
                            'name' => $fileName,
                            'size' => $imageFile->size,
                            'url' => $path,
                            'thumbnailUrl' => $path,
                            'deleteUrl' => 'image-delete?name=' . $fileName,
                            'deleteType' => 'POST',
                        ],
                    ],
                ]);
            }
        }

        return '';
    }

    public function actionImageDelete($name)
    {
        $directory = Yii::getAlias('@frontend/web/img/temp') . DIRECTORY_SEPARATOR . Yii::$app->session->id;
        if (is_file($directory . DIRECTORY_SEPARATOR . $name)) {
            unlink($directory . DIRECTORY_SEPARATOR . $name);
        }

        $files = FileHelper::findFiles($directory);
        $output = [];
        foreach ($files as $file) {
            $fileName = basename($file);
            $path = '/img/temp/' . Yii::$app->session->id . DIRECTORY_SEPARATOR . $fileName;
            $output['files'][] = [
                'name' => $fileName,
                'size' => filesize($file),
                'url' => $path,
                'thumbnailUrl' => $path,
                'deleteUrl' => 'image-delete?name=' . $fileName,
                'deleteType' => 'POST',
            ];
        }
        return Json::encode($output);
    }
    
}