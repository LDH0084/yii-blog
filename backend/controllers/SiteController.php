<?php
namespace backend\controllers;

use backend\models\Nav;
use common\models\Manager;
use Yii;


class SiteController extends BackendController
{

    public function init()
    {
        parent::init(); // TODO: Change the autogenerated stub
        if(!Yii::$app->session->has(Manager::MANAGER_ID) && !Yii::$app->session->has(Manager::MANAGER_ACCOUNT)) {
            return Yii::$app->response->redirect(['login/index']);
        }
    }

    //首页
    public function actionIndex()
    {
        return $this->renderPartial('index');
    }

    //导航列表
    public function actionNav()
    {
        $nav = new Nav();
        return json_encode($nav -> getNav(Yii::$app->request->post('id')));
    }

    //管理员退出
    public function actionLogout()
    {
        $manager = new Manager();
        if($manager->logout()) {
            echo "<script>alert('恭喜你，管理员退出成功');location.reload();</script>";
        }
    }




















}
