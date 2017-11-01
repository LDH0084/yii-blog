<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/12/13
 * Time: 19:20
 */

namespace common\components;
use Yii;

class Redis
{

    /*
     * 添加字符串类型缓存
     * */
    public static function set($key, $value, $expire = 0)
    {
        return Yii::$app->cache->set($key, $value, $expire);
    }

    /*
     * 获取字符串类型缓存
     * */
    public static function get($key)
    {
        return Yii::$app->cache->get($key);
    }

    /*
     * 添加
     * */









}