<?php
namespace frontend\controllers;

use common\components\Helper;
use common\components\Redis;
use common\models\Technology;
use Yii;
use yii\helpers\ArrayHelper;
use yii\redis\Connection;

/**
 * Site controller
 */
class TestController extends CommonController
{

    /*
     * 博客首页
     * */
    public function actionIndex()
    {
        $data = $this->GetIpLookup('222.76.57.85');
        $address = $data['country'].'-'. $data['province'].'-'.$data['city'];
        echo $address;
    }

    public function actionIndex2()
    {
        if(Helper::isMobile()) {
            echo 'ismobile';
        } else {
            echo 'ispc';
        }
    }


    public function actionIndex3()
    {
        $data = Technology::find()->select('id,title')->limit(3)->all();
        $redisObj = Yii::$app->redis;
        //$redisObj->hmset('user:1','a','b','c','d');
        $a = $redisObj->hget('user:1', 'b');
        print_r($a);
    }


}
