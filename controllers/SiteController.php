<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use app\components\MyController;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\SignupForm;
use app\models\ContactForm;
use app\models\GenerateNewPassword;
use app\models\UserModel;
use app\models\RePassword;
use app\models\ContactModel;

class SiteController extends MyController
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout','signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }
    
    public function beforeAction($action)
    {
        $this->enableCsrfValidation = false;
        
        return parent::beforeAction($action);
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /*public function actionIndex()
    {
        return $this->render('index');
    }*/

    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post())) {
            $contact = new ContactModel();
            $contact->name = $model->name;
            $contact->email = $model->email;
            $contact->other = $model->other;
            $contact->body = $model->body;
            $contact->subject = $model->subject;
            $contact->create_time = date('Y-m-d H:i:s');
            $contact->ip = Yii::$app->request->getUserIP();
            if($contact->save()){
                $check = \app\models\SettingModel::find()->where(['type'=>'sentmail'])->one();
                $admin_mail = \app\models\MainDataModel::find()->where(['type'=>'email'])->one();
                if($check->setting == 1 && $admin_mail && $admin_mail->content != ''){
                    $model->contact($admin_mail->content);
                }
                Yii::$app->session->setFlash('contactFormSubmitted');

                return $this->refresh();
            }
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }
    
    /*public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                Yii::$app->getSession()->setFlash('signupActivate',[
                    'body'=>'สมัครสมาชิกเสร็จเรียบร้อย! ท่านสามารถลงชื่อเข้าใช้งานได้แล้วในขณะนี้',
                    'options'=>['class'=>'alert-success']
                ]);

                return $this->refresh();
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }*/
    /*public function actionResetpassword()
    {
        $model = new GenerateNewPassword();
        if ($model->load(Yii::$app->request->post())) {
            if ($model->check()) {
                Yii::$app->getSession()->setFlash('resetpw',[
                    'body'=>'ระบบได้ทำการส่งอีเมล์ให้ท่านเรียบร้อย! ท่านสามารถเข้าไปยืนยันการเปลี่ยนรหัสผ่านได้ตามอีเมล์ที่ได้ลงทะเบียนไว้.',
                    'options'=>['class'=>'alert-success']
                ]);
                return $this->refresh();
            }
        }

        return $this->render('resetpassword', [
            'model' => $model,
        ]);
    }*/
    
    public function actionPwreset() {
        $u = Yii::$app->request->get('u');
        $r = Yii::$app->request->get('r');
        $l = Yii::$app->request->get('l');
        
        $check = null;
        if($u && $r && $l){
            $username = base64_decode(base64_decode($u));
            $check = UserModel::find()->where(['username' => $username, 'resetpw_r' => $r, 'resetpw_l' => $l])->one();
        }
        if($check){
            
            $model = new RePassword();
            $model->id = $check->id;
            if ($model->load(Yii::$app->request->post())) {
                if ($user = $model->resetByForget()) {
                    Yii::$app->getSession()->setFlash('updatepw',[
                        'body'=>'แก้ไขรหัสผ่านใหม่เรียบร้อย! ท่านสามารถ Login ได้โดยใช้รหัสผ่านนี้.',
                        'options'=>['class'=>'alert-success']
                    ]);
                }
            }
            return $this->render('newpw', [
                'model' => $model,
            ]);
        }
        else{
            throw new \yii\web\NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    
    //regist login resetpw check from ajax
    public function actionCheckLogin() {
        if(Yii::$app->request->post()){
            $model = new LoginForm();
            $model->username = Yii::$app->request->post('u');
            $model->password = Yii::$app->request->post('p');
            $model->rememberMe = Yii::$app->request->post('r');
            if($model->login()){
                return 1;
            }
            else{
                return json_encode($model->errors);
            }
            
        }
        return 0;
    }
    
    public function actionCheckSignup() {
        if(Yii::$app->request->post()){
            $model = new SignupForm();
            $model->username = Yii::$app->request->post('username');
            $model->email = Yii::$app->request->post('email');
            $model->password = Yii::$app->request->post('password');
            $model->re_password = Yii::$app->request->post('repassword');
            $model->verifyCode = Yii::$app->request->post('verification');
            if(Yii::$app->request->post('agree') && Yii::$app->request->post('agree')==1){
                $model->agree_rule = 1;
            }
            else{
                $model->agree_rule = null;
            }
            if($model->signup()){
                return 1;
            }
            else{
                return json_encode($model->errors);
            }
            
        }
        return 0;
    }
    public function actionResetPw()
    {
        
        if (Yii::$app->request->post()) {
            $model = new GenerateNewPassword();
            $model->username = Yii::$app->request->post('data');
            if ($model->check()) {
                return 1;
            }
            else{
                return json_encode($model->errors);
            }
        }
        return 0;
    }
    public function actionPrivacypolicy() {
        return $this->render('privacy_policy');
    }
    
    public function actionFblogin() {
        $user = Yii::$app->facebook->fb_user_data();
        if (isset($user['id']) && isset($user['name'])) {
            $id = $user['id'];
            $name = $user['name'];
            $email = isset($user['email']) ? $user['email'] : $id . '@fbaccount.com';
            
            if($this->check_fb_login($id)){
                return $this->goBack();
            }
            else{
                if($this->regist_fb_login($id, $name,$email)){
                    if($this->check_fb_login($id)){
                        return $this->goBack();
                    }
                }
            }
        }
        throw new \yii\web\NotFoundHttpException('The requested error.');
        
    }
    
    protected function check_fb_login($id) {
        $model = new LoginForm();
        $model->username = $id;
        $model->password = md5(sha1(base64_encode($id)));
        $model->rememberMe = true;
        if ($model->login()) {
            return true;
        }
        return FALSE;
    }
    
    protected function regist_fb_login($id, $name, $email=null) {
        $model = new \app\models\FacebookSignup();
        $model->username = $id;
        $model->email = $email;
        $model->nickname = $name;
        $model->image = $this->get_fb_profile_img($id);
        $model->password = md5(sha1(base64_encode($id)));
        $model->re_password = md5(sha1(base64_encode($id)));

        if($model->signup()){
            return true;
        }
        return FALSE;
        
    }
    
    protected function get_fb_profile_img($id) {
        
        $url = 'http://graph.facebook.com/'.$id.'/picture?type=large';
        $data = file_get_contents($url);
        $path = '/uploads/img/profile/';
        $name = date('Ymd-his') . '-' . $id . '.jpg';
        $fileName = $path . $name;
        $file = fopen(Yii::$app->basePath .'/web'.$fileName, 'w+');
        fputs($file, $data);
        fclose($file);
        
        return $fileName;
    }
}
