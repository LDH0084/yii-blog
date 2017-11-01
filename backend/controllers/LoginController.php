<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/5/26
 * Time: 13:24
 */

namespace backend\controllers;
use common\models\Manager;
use Yii;

class LoginController extends BackendController
{


    public function init()
    {
        parent::init();
        //判断用户是否登录
        if(Yii::$app->session->has(Manager::MANAGER_ID) && Yii::$app->session->has(Manager::MANAGER_ACCOUNT)) {
            return Yii::$app->response->redirect(['site/index']);
        }
    }

    public function actions()
    {
        return [
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'maxLength' => 4,
                'minLength' => 4,
                'width' => 100,
                'height' => 40
            ]
        ];
    }

    public function actionIndex()
    {
        $this->layout = 'empty';
        $model = new Manager();
        if(Yii::$app->request->isPost && $model->load(Yii::$app->request->post()) && $model->validate() && $model->login()){
            Yii::$app->response->redirect(['site/index']);
        }
        return $this->render('login', ['model' => $model]);
    }







}