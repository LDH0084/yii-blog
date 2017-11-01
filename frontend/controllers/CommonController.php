<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/4/28
 * Time: 12:24
 */

namespace frontend\controllers;
use common\models\Notice;
use common\models\Websetting;
use Yii;
use yii\web\Controller;
use common\models\User;

class CommonController extends Controller
{
    public $userId;
    public $userAccount;

    public function init()
    {
        parent::init();
        $this->getUserSession();    //获取session
        if(Yii::$app->cache->get('websetting')) {   //获取网站设置
            $websetting = Yii::$app->cache->get('websetting');
        } else {
            $websetting = Websetting::find()->where(['id'=> 1])->asArray()->one();
            Yii::$app->cache->set('websetting', $websetting);
        }
        $view = Yii::$app->view;
        $view->params['websetting'] = $websetting;
    }

    //获取session
    public function getUserSession()
    {
        $session = Yii::$app->session;
        $this->userId = $session->get(User::USER_ID);
        $this->userAccount = $session->get(User::USER_ACCOUNT);
        if(!empty($this->userId) && !empty($this->userAccount)){
            return true;
        }else{
            $user = new User();
            if($user->loginByCookie()){
                return true;
            }
            return false;
        }
    }


































}