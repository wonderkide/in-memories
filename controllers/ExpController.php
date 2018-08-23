<?php

namespace app\controllers;

use Yii;
use app\models\LogExpModel;
use app\models\LogExpSearchModel;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\SettingModel;

/**
 * ExpController implements the CRUD actions for LogExpModel model.
 */
class ExpController extends Controller
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
     * Lists all LogExpModel models.
     * @return mixed
     */
    /*public function actionIndex()
    {
        $searchModel = new LogExpSearchModel();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }*/

    /**
     * Displays a single LogExpModel model.
     * @param integer $id
     * @return mixed
     */
    /*public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }*/

    /**
     * Creates a new LogExpModel model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    /*public function actionCreate()
    {
        $model = new LogExpModel();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }*/

    /**
     * Updates an existing LogExpModel model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    /*public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }*/

    /**
     * Deletes an existing LogExpModel model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    /*public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }*/

    /**
     * Finds the LogExpModel model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return LogExpModel the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = LogExpModel::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    public function createLogEXP($user, $id_cat, $cat, $detail, $bonus = FALSE) {
        $status = SettingModel::findOne(['type'=>'exp_for_comment']);
        if($status->setting){
            $exp = \app\models\ExpModel::findOne(['category'=>$cat]);
            
            $model = new LogExpModel();
            $model->id_user = $user;
            $model->id_admin = null;
            $model->id_cat = $id_cat;
            $model->category = $cat;
            $model->detail = $detail;
            if(!$exp){
                $model->exp = Yii::$app->params['defaultEXP'];
            }else{
                if($bonus){
                    $model->exp = $exp->exp_bonus;
                }
                else{
                    $model->exp = $exp->exp;
                }
            }
            $model->create_time = date('Y-m-d');
            $model->active = 0;
            if($model->save()){
                return true;
            }
            else{
                return FALSE;
            }
        }
    }
}