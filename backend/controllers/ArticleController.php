<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/10/28 0028
 * Time: 13:55
 */

namespace backend\controllers;
use common\models\Technology;
use common\models\TechnologyComment;
use common\models\TechnologyTypes;
use Yii;

class ArticleController extends BackendController
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

    //技术博文类型页面
    public function actionTechnologytypes()
    {
        $pidData = TechnologyTypes::find()->where(['pid'=>0])->asArray()->all();
        return $this->renderPartial('technologytypes', ['pidData'=> $pidData]);
    }

    //获取技术博文类型列表
    public function actionTechnologytypeslist()
    {
        return json_encode(TechnologyTypes::getTechnologyTypesList(Yii::$app -> request -> post()));
    }

    //添加技术博文类型
    public function actionAddtechnologytypes()
    {
        if(Yii::$app -> request -> isPost) {
            echo TechnologyTypes::addTechnologyTypes(Yii::$app->request->post());
        }
    }

    //获取一条修改技术博文类型数据
    public function actionOnetechnologytypes()
    {
        $id = Yii::$app -> request -> post('id');
        return json_encode(TechnologyTypes::oneTechnologyTypes($id));
    }

    //修改一条技术博文类型数据
    public function actionEdittechnologytypes()
    {
        if(Yii::$app -> request -> isPost) {
            echo TechnologyTypes::editTechnologyTypes(Yii::$app->request->post());
        }
    }

    //删除技术博文类型数据
    public function actionDeletetechnologytypes()
    {
        if(Yii::$app -> request -> isPost) {
            echo TechnologyTypes::deleteTechnologyTypes(Yii::$app->request->post('ids'));
        }
    }


    //技术博客页面
    public function actionTechnology()
    {
        return $this->renderPartial('technology');
    }

    //获取技术博客列表
    public function actionTechnologylist()
    {
        return json_encode(Technology::getTechnologyList(Yii::$app -> request -> post()));
    }

    //添加技术博客
    public function actionAddtechnology()
    {
        $model = new Technology();
        if(Yii::$app->request->isPost && $model->load(Yii::$app->request->post()) && $model->save()){
            Yii::$app->cache->delete('technologyDataoffset0id0'); //删除缓存
			Yii::$app->session->setFlash('success' , '技术博客添加成功');
            return Yii::$app->response->redirect(['article/addtechnology']);
        }
        return $this->render('addtechnology',['model'=>$model]);
    }

    //修改技术博客
    public function actionEdittechnology()
    {
        $id = Yii::$app->request->get('id' , 0);
        $model = Technology::findOne($id);
        if(Yii::$app->request->isPost && $model->load(Yii::$app->request->post()) && $model->save()){
            Yii::$app->session->setFlash('success' , '技术博客修改成功');
            return Yii::$app->response->redirect(['article/edittechnology','id'=>$id]);
        }
        return $this->render('edittechnology', ['model' => $model]);
    }

    //删除技术博客
    public function actionDeletetechnology()
    {
        if(Yii::$app -> request -> isPost) {
            echo Technology::deleteTechnology(Yii::$app->request->post('ids'));
        }
    }



















    //技术博客评论页面
    public function actionTechnologycomment()
    {
        return $this->renderPartial('technologycomment');
    }

    //获取技术评论列表
    public function actionTechnologycommentlist()
    {
        return json_encode(TechnologyComment::getTechnologyCommentList(Yii::$app -> request -> post()));
    }

    //修改技术评论
    public function actionShowtechnologycomment()
    {
        $id = Yii::$app->request->get('id' , 0);
        $model = TechnologyComment::findOne($id);
        return $this->render('showtechnologycomment', ['model' => $model]);
    }

    //删除技术评论
    public function actionDeletetechnologycomment()
    {
        if(Yii::$app -> request -> isPost) {
            echo TechnologyComment::deleteTechnologyComment(Yii::$app->request->post('ids'));
        }
    }

























































}