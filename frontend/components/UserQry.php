<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/11/4 0004
 * Time: 16:28
 */

namespace frontend\components;

use Yii;
use common\models\User;

class UserQry extends BaseQry
{

    /*
     * 加载用户头像
     * */
    public function checkFace($account)
    {
        $data = User::find()->where(['account'=> $account])->asArray()->one();
        if($data) {
            return $data['face'];
        } else {
            return false;
        }
    }

    /*
     * 找回密码，验证用户资料
     * */
    public function findPassword($account, $mail)
    {
        $data = User::find()->where(['account'=> $account, 'mail'=> $mail])->asArray()->one();
        if($data) {
            if($data['status'] == 1) {
                return true;
            } else {
                return -2;
            }
        } else {
            return -1;
        }
    }

    /*
     * 重置密码
     * */
    public function resetpassword($id, $post)
    {
        $password = $post['password'];
        if(mb_strlen($password) >= 6) {
            $newPassword = sha1($password.'www.amgogo.com');
            $sql = "UPDATE {{%user}} SET password = '$newPassword' WHERE id ='$id'";
            Yii::$app->db->createCommand($sql)->execute();
            return true;
        } else {
            return -1;
        }
    }

    /*
     * 通过用户名找用户
     * */
    public function getUserByAccount($account)
    {
        return User::find()->where(['account'=>$account])->asArray()->one();
    }






















}