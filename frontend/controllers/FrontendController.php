<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/11/16 0016
 * Time: 16:36
 */

namespace frontend\controllers;
use common\models\User;
use Yii;

class FrontendController extends CommonController
{

    public function init()
    {
        parent::init();
        if(!Yii::$app->session->has(User::USER_ID) || !Yii::$app->session->has(User::USER_ACCOUNT)) {
            return Yii::$app->response->redirect(['site/index']);
        }
    }


}