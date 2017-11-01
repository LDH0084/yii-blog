<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/5/8
 * Time: 8:41
 */
namespace common\models;
use yii\db\ActiveRecord;
use Yii;
use yii\web\Cookie;
use yii\helpers\Url;

class User extends ActiveRecord
{

    public $user;
    public $verifyCode;
    public $oldpassword;
    public $repassword;
    public $keep;
    const USER_ID = 'user_id';
    const USER_ACCOUNT = 'user_account';
    const USER_FACE = 'user_face';
    const USER_KEEP = 'user_keep';

    //头像信息
    public $file_face_flag = true;
    public $file_max_size = 2097152;    //2M
    public $file_upload_types = array('image/jpeg','image/png','image/jpg');
    public $file_save = '';

    public static function tableName()
    {
        return '{{%user}}';
    }



    public function rules()
    {
        return [
//            ['verifyCode' , 'captcha' , 'captchaAction' => 'login/captcha' , 'message' => '验证码错误'],
            [['account','mail','password'], 'required', 'message' => '请填写信息，内容不得为空'],
            ['account', 'checkNickName' , 'skipOnEmpty'=> false],
            ['account', 'unique', 'message'=> '很遗憾，用户名被占用'],
            ['mail', 'email' , 'message'=> '请输入正确邮箱'],
            ['password', 'string', 'min'=> 6, 'max'=> 25, 'tooShort'=> '密码长度不得小于6位', 'tooLong'=> '密码长度不得多于25位'],
            ['repassword', 'compare', 'compareAttribute'=> 'password', 'skipOnEmpty'=> false, 'message'=> '密码输入不一致'],
            [['face', 'keep', 'signature'], 'safe'],
        ];
    }

    /*
     * 验证用户名
     * */
    public function checkNickName($attribute ,$params)
    {
        if(mb_strlen($this->$attribute) > 20 || mb_strlen($this->$attribute) < 2){
            $this->addError($attribute , '用户名不得小于2位或大于20位');
        }else if(preg_match("/[@\s\\/\.\<\>]/" , $this->$attribute)){
            $this->addError($attribute , '用户名不得包含特殊字符');
        }
    }

    //用户添加之前处理数据
    public function beforeSave($insert)
    {
        if(parent::beforeSave($insert)){
            if($this->isNewRecord){
                $this->create_time = time();
                $this->password = sha1($this->password.'www.amgogo.com');
            }
//            if($this->file_save != '') {
//                $this->face = $this->file_save;
//            }
            $this->login_time = time();
            $this->login_ip = Yii::$app->request->getUserIP();
            if($this->file_face_flag) {
                return true;
            }
        }
        return false;
    }

    /*
     * 保存头像
     * */
    public function saveFace($files)
    {
        $file_upload_type = $files['type'];  //取得图片上传的类型
        $file_upload_size = $files['size'];  //取得图片上传的大小
        $file_upload_name = $files['name'];  //取得图片上传的名称
        $file_upload_address = $files['tmp_name'];  //取得图片上传的临时地址
        if(empty($file_upload_type)) {  //没有上传头像，直接返回true
            return false;
        }
        $file_upload_suffix =  substr($file_upload_name,-4);;  //取得图片的后缀
        //判断上传的图片类型
        if(!in_array($file_upload_type, $this->file_upload_types)) {
            $this->file_face_flag = false;
        }
        //判断图片的大小
        if($file_upload_size > $this->file_max_size) {
            $this->file_face_flag = false;
        }
        $file_save_name = date('YmdHis').rand(1,10000).$file_upload_suffix;    //图片保存的名称
        $file_save_address = Yii::$app->basePath.'/web/upload/'.$file_save_name;   //保存的路径
        $file_mysql_address = Url::base().'/upload/'.$file_save_name;   //保存到数据库的路径
        if(move_uploaded_file($file_upload_address,$file_save_address)) {   //保存图片
            return base64_encode($file_mysql_address);
        }
    }

    /*
     * 用户登录
     * */
    public function login()
    {
        $userData = User::find()->where(['account' => $this->account])->asArray()->one();
        if($userData && sha1($this->password.'www.amgogo.com') == $userData['password']){
            if($userData['status'] == '-1') {
                return -2;
            } else {
                $this->user = $userData;
            }
        }else{
            return -1;
        }
        if(!$this->user || !$this->updateUserStatus()) return false;
        $this->createSession();
        if(!empty($this->keep)){
            $this->createCookie();
        }
        return true;
    }

    /*
     * 用户登录生成session
     * */
    private function createSession()
    {
        $session = Yii::$app->session;
        $session->set(self::USER_ID, $this->user['id']);
        $session->set(self::USER_ACCOUNT, $this->user['account']);
        $session->set(self::USER_FACE, base64_decode($this->user['face']));
    }

    /*
     * 用户登录保持登录信息，生成cookie
     * */
    private function createCookie()
    {
        $cookie = new Cookie();
        $cookie->name = self::USER_KEEP;
        $cookie->value = [
            'id' => $this->user['id'],
            'account' => $this->user['account'],
            'face' => $this->user['face']
        ];
        $cookie->expire = time() + 60*60*24*7;
        $cookie->httpOnly = true;   //js不能获取
        Yii::$app->response->cookies->add($cookie);
    }

    /*
     * 通过cookie登录
     * */
    public function loginByCookie()
    {
        $cookies = Yii::$app->request->cookies;
        if($cookies->has(self::USER_KEEP)){
            $userData = $cookies->getValue(self::USER_KEEP);
            if(isset($userData['id']) && isset($userData['account'])){
                $session = Yii::$app->session;
                $session->set(self::USER_ID, $userData['id']);
                $session->set(self::USER_ACCOUNT, $userData['account']);
                $session->set(self::USER_FACE, base64_decode($userData['face']));
                return true;
            }
        }
        return false;
    }

    /*
     * 更新用户数据
     * */
    public function updateUserStatus()
    {
        $user = User::findOne($this->user['id']);
        unset($user->password);
        $user->login_time = time();
        $user->login_ip = Yii::$app->request->getUserIP();
        return $user->save(false);
    }

    /*
     * 用户退出
     * */
    public static function logout()
    {
        $session = Yii::$app->session;
        $session->remove(self::USER_ID);
        $session->remove(self::USER_ACCOUNT);
        $session->remove(self::USER_FACE);
        $cookies = Yii::$app->request->cookies;
        if($cookies->has(self::USER_KEEP)){
            $rememberCookie = $cookies->get(self::USER_KEEP);
            Yii::$app->response->cookies->remove($rememberCookie);
        }
        return true;
    }

    /*
     * 修改用户资料
     * */
    public function editUser($uid, $post, $faceData)
    {
        $model = self::findOne($uid);
        if($post['oldpassword'] != '') {
            $oldpassword = sha1($post['oldpassword'].'www.amgogo.com');
            if(User::find()->where(['id'=> $uid,'password'=>$oldpassword])->one()) {
                $model->password = sha1($post['password'].'www.amgogo.com');
            } else {
                //原密码错误
                return false;
            }
        }
        if($faceData) {
            $model->face = $faceData;
        }
        $model->signature = $post['signature'];
        $model->mail = $post['mail'];
        return $model->save(false);
    }


















    

    //获取用户列表
    public static function getUserList($post)
    {
        $page = $post['page'];
        $rows = $post['rows'];
        $sort = $post['sort'];
        $order = $post['order'];
        $account = isset($post['account']) ? $post['account'] : '';
        $date_from = isset($post['date_from']) ? $post['date_from'] : '';
        $date_to = isset($post['date_to']) ? $post['date_to'] : '';
        $map = array();
        $map2 = array();
        $map3 = array();
        if ($account) {
            $map = array('like', 'account', $account);
        }
        if ($date_from && $date_to) {
            $map2 = array('>=', 'create_time', strtotime($date_from));
            $map3 = array('<=', 'create_time', strtotime($date_to) + 24*60*60);
        } else if ($date_from) {
            $map2 = array('>=', 'create_time', strtotime($date_from));
        } else if ($date_to) {
            $map2 = array('<=', 'create_time', strtotime($date_to) + 24*60*60);
        }
        $obj = self::find()
            -> andFilterWhere($map) ->andFilterWhere($map2) ->andFilterWhere($map3)
            -> select('id,account,mail,signature,,create_time,login_time,login_ip,status')-> orderBy('create_time '.$order)
            -> offset($rows * ($page - 1))-> limit($rows)-> asArray()-> all();
        foreach ($obj as $key=>$value) {
            $obj[$key]['create_time'] = date('Y-m-d H:i:s', $value['create_time']);
            $obj[$key]['login_time'] = date('Y-m-d H:i:s', $value['login_time']);
            $obj[$key]['login_ip'] = long2ip($value['login_ip']);
            $obj[$key]['statuscopy'] = $value['status'] == '1' ? '正常' : '冻结';
        }
        //echo $this->getLastSql();
        return array(
            'total'=>self::find()->where($map)->count(),
            'rows'=>$obj ? $obj : '',
        );
    }

    //获取一条用户
    public static function oneUser($id)
    {
        $data = self::find()->where(['id' => $id])->asArray()->one();
        return $data ? $data : '';
    }

    //添加一个用户
    public static function addUser($post)
    {
        $account = $post['account'];
        $password = sha1($post['password']);
        $mail = $post['mail'];
        $User = self::find();
        if(mb_strlen($post['password'], 'utf-8') < 6) {
            return -3;
        }
        $data = $User -> where(['account' => $account]) ->one();
        if($data) {
            return -1;
        }
        $time = time();
        $sql = "INSERT INTO {{%user}} (account, password, mail, create_time) VALUES ('$account', '$password', '$mail', '$time')";
        if(Yii::$app->db->createCommand($sql)->execute()) {
            return true;
        }
    }

    //修改用户资料
    public static function editUserBackend($post)
    {
        $id = $post['id'];
        $account = $post['account'];
        $password = sha1($post['password']);
        $mail = $post['mail'];
        $User = self::find();
        if(mb_strlen($post['password'], 'utf-8') < 6 && mb_strlen($post['password'], 'utf-8') != 0) {
            return -3;
        }
        $data = $User -> where(['account' => $account]) -> andWhere(['!=', 'id', $id])  ->one();
        if($data) {
            return -1;
        }
        if(mb_strlen($post['password'], 'utf-8') == 0) {
            $sql = "UPDATE {{%user}} SET account='$account',mail='$mail' WHERE id=$id";
        } else {
            $sql = "UPDATE {{%user}} SET account='$account',password='$password',mail='$mail' WHERE id=$id";
        }

        if(Yii::$app->db->createCommand($sql)->execute()) {
            return true;
        } else {
            return -4;
        }
    }

    //解封一条或多条用户
    public static function unfreezeUser($post)
    {
        $sql = "UPDATE {{%user}} SET status = '1' WHERE id IN ($post)";
        if(Yii::$app->db->createCommand($sql)->execute()) {
            return 1;
        } else {
            return -1;
        }
    }

    //冻结一条或多条用户
    public static function freezeUser($post)
    {
        $sql = "UPDATE {{%user}} SET status = '-1' WHERE id IN ($post)";
        if(Yii::$app->db->createCommand($sql)->execute()) {
            return 1;
        } else {
            return -1;
        }
    }

    //删除一条或多条用户
    public static function deleteUser($post)
    {
        $sql = "DELETE FROM {{%user}} WHERE id IN ($post)";
        if(Yii::$app->db->createCommand($sql)->execute()) {
            return 1;
        } else {
            return -1;
        }
    }




















}