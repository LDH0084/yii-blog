<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/11/19
 * Time: 22:31
 */

namespace backend\controllers;
use common\models\User;
use Yii;

class UserController extends BackendController
{

    //用户页面
    public function actionIndex()
    {
        return $this->renderPartial('user');
    }

    //获取用户列表
    public function actionUserlist()
    {
        return json_encode(User::getUserList(Yii::$app -> request -> post()));
    }

    //添加用户
    public function actionAdduser()
    {
        if(Yii::$app -> request -> isPost) {
            echo User::addUser(Yii::$app->request->post());
        }
    }

    //获取一条修改用户数据
    public function actionOneuser()
    {
        $id = Yii::$app -> request -> post('id');
        return json_encode(User::oneUser($id));
    }

    //修改一条用户数据
    public function actionEdituser()
    {
        if(Yii::$app -> request -> isPost) {
            echo User::editUserBackend(Yii::$app->request->post());
        }
    }

    //解封用户
    public function actionUnfreezeuser()
    {
        if(Yii::$app -> request -> isPost) {
            echo User::unfreezeUser(Yii::$app->request->post('ids'));
        }
    }

    //冻结用户
    public function actionFreezeuser()
    {
        if(Yii::$app -> request -> isPost) {
            echo User::freezeUser(Yii::$app->request->post('ids'));
        }
    }

    //删除用户数据
    public function actionDeleteuser()
    {
        if(Yii::$app -> request -> isPost) {
            echo User::deleteUser(Yii::$app->request->post('ids'));
        }
    }








    
}