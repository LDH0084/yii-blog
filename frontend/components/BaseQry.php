<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/5/25
 * Time: 15:46
 */

namespace frontend\components;


use common\models\User;

abstract class BaseQry
{
    protected static $instance;

    public static function getInstance()
    {
        $class = get_called_class();
        if (!isset(self::$instance[$class])) {
            self::$instance[$class] = new $class;
        }
        return self::$instance[$class];
    }

    protected function getNickName($uid)
    {
        return User::find()->where(['id' => $uid])->asArray()->one()['nickname'];
    }

    protected function getUserHome($uid)
    {
        return User::find()->where(['id' => $uid])->asArray()->one()['home'];
    }

    protected function getUserFace($uid)
    {
        $face = User::find()->where(['id' => $uid])->asArray()->one()['face'];
        if(empty($face)) {
            $face = './upload/face/face-detault.jpg';
        }
        return $face;
    }

    public function getIpLookup(){
        $ip = '218.106.150.234';
        $res = @file_get_contents('http://int.dpool.sina.com.cn/iplookup/iplookup.php?format=js&ip='.$ip);
        if(empty($res)){ return false; }
        $jsonMatches = array();
        preg_match('#\{.+?\}#', $res, $jsonMatches);
        if(!isset($jsonMatches[0])){ return false; }
        $json = json_decode($jsonMatches[0], true);
        if(isset($json['ret']) && $json['ret'] == 1){
            $json['ip'] = $ip;
            unset($json['ret']);
        }else{
            return false;
        }
        return $json;
    }







}