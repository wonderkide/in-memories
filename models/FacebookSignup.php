<?php
namespace app\models;

//use common\models\User;
use app\models\UserAuth;
use yii\base\Model;
use Yii;
use app\models\RankModel;

/**
 * Signup form
 */
class FacebookSignup extends Model
{
    public $username;
    public $email;
    public $password;
    public $re_password;
    public $permission;
    public $zeny = 10000;
    public $nickname;
    public $image;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'filter', 'filter' => 'trim'],
            ['username', 'required', 'message' => 'กรุณากรอก {attribute}'],
            //['username', 'match', 'pattern' => '/^[a-z]\w*$/i', 'message' => 'ห้ามใช้อักขระพิเศษ และมีช่องว่าง ท่านสามารถใช้ a-z และ 0-9 ได้เท่านั้น'],
            //['username', 'unique'],
            ['username', 'unique', 'targetClass' => 'app\models\UserAuth', 'message' => 'Username นี้ถูกใช้ไปแล้ว'],
            //['username', 'string', 'min' => 6, 'max' => 14],
            [['nickname'], 'string', 'max' => 128],

            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required', 'message' => 'กรุณากรอก {attribute}'],
            ['email', 'email', 'message' => 'กรุณากรอกรูปแบบ {attribute} ให้ถูกต้อง'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => 'app\models\UserAuth', 'message' => 'Email นี้ถูกใช้ไปแล้ว'],

            ['password', 'required', 'message' => 'กรุณากรอก {attribute}'],
            //['password', 'string', 'min' => 8, 'max' => 18],
            
            //['re_password', 'required', 'message' => 'กรุณากรอก {attribute}'],
            //['re_password','compare','compareAttribute'=>'password', 'message' => 'กรุณากรอก {attribute} ให้ตรงกับ รหัสผ่าน'],
            
            //['permission', 'required'],
            ['permission', 'integer'],
            ['zeny', 'number'],
            //['verifyCode', 'captcha'],
            
            ['username', 'allowUser'],
            
            //['agree_rule', 'required', 'message' => 'ท่านต้องยอมรับเงื่อนไขการใช้งาน'],
        ];
    }
    
    public function attributeLabels()
    {
        return [
            'username' => 'ชื่อผู้ใช้',
            'password' => 'รหัสผ่าน',
            'email' => 'อีเมล์',
            're_password' => 'ยืนยันรหัสผ่าน',
            'verifyCode' => 'Verification Code',
        ];
    }
    
    public function allowUser($attribute, $params) {
        $model = MainDataModel::find()->where(['type'=>'allowuser'])->one();
        $not = explode(',', $model->content);
        foreach ($not as $value) {
            if(is_numeric(strpos($this->$attribute, $value))){
                $this->addError($attribute, 'คุณไม่สามารถใช้งาน Username ชื่อนี้ได้.');
            }
            
        }
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        if ($this->validate()) {
            $user = new UserAuth();
            $rank = RankModel::findOne(['exp'=>0]);
            $user->id_rank = $rank->id;
            $user->exp = $rank->exp;
            if($this->permission){
                $user->permission = $this->permission;
            }
            else{
                $user->permission = 1;
            }
            $user->username = $this->username;
            $user->email = $this->email;
            $user->zeny = $this->zeny;
            $user->ip = Yii::$app->request->getUserIP();
            $user->post_point = SettingModel::getPoint();
            $user->notify = 0;
            $user->nickname = $this->nickname;
            $user->image = $this->image;
            $user->image_crop = $this->image;
            
            $user->setPassword($this->password);
            $user->generateAuthKey();
            $user->generatePasswordResetToken();
            if ($user->save()) {
                return $user;
            }
        }

        return null;
    }
}
