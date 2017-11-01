<?php
/**
 * Created by PhpStorm.
 * User: Manageristrator
 * Date: 2016/7/11 0011
 * Time: 10:04
 */

namespace backend\controllers;


use common\models\Manager;
use common\models\Notice;
use common\models\Websetting;
use Yii;

class SystemController extends BackendController
{

    //关闭csrf 跨站检测攻击
    public $enableCsrfValidation = false;
    public function actions() {
        return [
            'upload' => [
                'class' => 'cliff363825\kindeditor\KindEditorUploadAction',
//图片保存的物理路径
                'savePath' => 'uploads',
//图片的 url
                'baseUrl' => '@web',
//图片的限制
                'maxSize' => 2097152,
            ]
        ];
    }

    //管理员页面
    public function actionManager()
    {
        return $this->renderPartial('manager');
    }

    //获取管理员列表
    public function actionManagerlist()
    {
        return json_encode(Manager::getManagerList(Yii::$app -> request -> post()));
    }

    //添加管理员
    public function actionAddmanager()
    {
        if(Yii::$app -> request -> isPost) {
            echo Manager::addManager(Yii::$app->request->post());
        }
    }

    //获取一条修改管理员数据
    public function actionOnemanager()
    {
        $id = Yii::$app -> request -> post('id');
        return json_encode(Manager::oneManager($id));
    }

    //修改一条管理员数据
    public function actionEditmanager()
    {
        if(Yii::$app -> request -> isPost) {
            echo Manager::editManager(Yii::$app->request->post());
        }
    }

    //删除管理员数据
    public function actionDeletemanager()
    {
        if(Yii::$app -> request -> isPost) {
            echo Manager::deleteManager(Yii::$app->request->post('ids'));
        }
    }

    //网站设置页面
    public function actionWebsetting()
    {
        $model = Websetting::findOne(1);
        if(Yii::$app->request->isPost && $model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->cache->delete('websetting'); //删除缓存
            Yii::$app->session->setFlash('success' , '网站设置修改成功');
            return Yii::$app->response->redirect(['system/websetting']);
        }
        return $this->render('websetting', ['model'=> $model]);
    }

    //网站通知
    public function actionNotice()
    {
        $model = Notice::findOne(1);
        if(Yii::$app->request->isPost && $model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->cache->delete('notice'); //删除缓存
            Yii::$app->session->setFlash('success' , '网站通知修改成功');
            return Yii::$app->response->redirect(['system/notice']);
        }
        return $this->render('notice', ['model'=> $model]);
    }









}