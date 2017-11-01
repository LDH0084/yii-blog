<?php
/**
 * Created by PhpStorm.
 * User: manageristrator
 * Date: 2016/7/22 0022
 * Time: 14:04
 */

namespace common\models;

use Yii;
use yii\db\ActiveRecord;

class Manager extends ActiveRecord
{
    public $password;
    public $remember;
    public $verifyCode;
    private $manager;
    const MANAGER_ID = 'Manager_id';
    const MANAGER_ACCOUNT = 'Manager_account';

    public static function tableName()
    {
        return '{{%manager}}';
    }

    public function rules()
    {
        return [
            ['account' , 'checkName' ,'skipOnEmpty' => false],
            ['verifyCode', 'captcha', 'captchaAction' => 'login/captcha' , 'message' => '！验证码错误'],
            ['password', 'safe']
        ];
    }

    public function checkName($attribute , $params)
    {
        if(mb_strlen($this->$attribute) > 20 || mb_strlen($this->$attribute) < 2){
            $this->addError($attribute , '！帐号或密码错误');
        }else if(preg_match("/[@\s\\/\.\<\>]/" , $this->$attribute)){
            $this->addError($attribute , '！帐号或密码错误');
        }else{
            $manager = Manager::find()->where(['account' => $this->$attribute , 'status' => 1])->asArray()->one();
            if(!$manager || $manager['password'] != sha1($this->password)){
                $this->addError($attribute , '！帐号或密码错误');
            }else{
                $this->manager = $manager;
            }
        }
    }

    //用户登录
    public function login()
    {
        if(!$this->manager || !$this->updateAdminStatus()) return false;
        $this->createSession();
        return true;
    }

    //更新用户数据
    public function updateAdminStatus()
    {
        $manager = Manager::findOne($this->manager['id']);
        unset($manager->password);
        $manager->login_time = time();
        $manager->login_ip = Yii::$app->request->getUserIP();
        return $manager->save(false);
    }

    private function createSession()
    {
        $session = Yii::$app->session;
        $session->set(self::MANAGER_ID , $this->manager['id']);
        $session->set(self::MANAGER_ACCOUNT , $this->manager['account']);
    }

    public function logout()
    {
        $session = Yii::$app->session;
        $session->remove(self::MANAGER_ID);
        $session->remove(self::MANAGER_ACCOUNT);
        return true;
    }

    //获取管理员列表
    public static function getManagerList($post)
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
            -> select('id,account,email,create_time,login_time,login_ip')-> orderBy('create_time '.$order)
            -> offset($rows * ($page - 1))-> limit($rows)-> asArray()-> all();
        foreach ($obj as $key=>$value) {
            $obj[$key]['create_time'] = date('Y-m-d H:i:s', $value['create_time']);
            $obj[$key]['login_time'] = date('Y-m-d H:i:s', $value['login_time']);
            $obj[$key]['login_ip'] = long2ip($value['login_ip']);
        }
        //echo $this->getLastSql();
        return array(
            'total'=>self::find()->where($map)->count(),
            'rows'=>$obj ? $obj : '',
        );
    }

    //获取一条管理员
    public static function oneManager($id)
    {
        $data = self::find()->where(['id' => $id])->asArray()->one();
        return $data ? $data : '';
    }

    //添加一个管理员
    public static function addManager($post)
    {
        $account = $post['account'];
        $password = sha1($post['password']);
        $email = $post['email'];
        $rank = $post['rank'];
        $manager = self::find();
        if(mb_strlen($post['password'], 'utf-8') < 6) {
            return -3;
        }
        $data = $manager -> where(['account' => $account]) ->one();
        if($data) {
            return -1;
        }
        $data2 = $manager -> where(['email' => $email]) ->one();
        if($data2) {
            return -2;
        }
        $time = time();
        $sql = "INSERT INTO {{%manager}} (account, password, email, create_time,rank,status) VALUES ('$account', '$password', '$email', '$time','$rank','1')";
        if(Yii::$app->db->createCommand($sql)->execute()) {
            return true;
        }
    }

    //修改管理员资料
    public static function editManager($post)
    {
        $id = $post['id'];
        $account = $post['account'];
        $password = sha1($post['password']);
        $email = $post['email'];
        $rank = $post['rank'];
        $manager = self::find();
        if(mb_strlen($post['password'], 'utf-8') < 6 && mb_strlen($post['password'], 'utf-8') != 0) {
            return -3;
        }
        $data = $manager -> where(['account' => $account]) -> andWhere(['!=', 'id', $id])  ->one();
        if($data) {
            return -1;
        }
        $data2 = $manager -> where(['email' => $email]) -> andWhere(['!=', 'id', $id]) ->one();
        if($data2) {
            return -2;
        }
        if(mb_strlen($post['password'], 'utf-8') == 0) {
            $sql = "UPDATE {{%manager}} SET account='$account',email='$email',rank='$rank' WHERE id=$id";
        } else {
            $sql = "UPDATE {{%manager}} SET account='$account',password='$password',email='$email',rank='$rank' WHERE id=$id";
        }

        if(Yii::$app->db->createCommand($sql)->execute()) {
            return true;
        } else {
            return -4;
        }
    }

    //删除一条或多条管理员
    public static function deletemanager($post)
    {
        $sql = "DELETE FROM {{%manager}} WHERE id IN ($post)";
        if(Yii::$app->db->createCommand($sql)->execute()) {
            return 1;
        } else {
            return -1;
        }
    }








}