<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/10/28 0028
 * Time: 13:55
 */

namespace backend\controllers;
use common\models\Video;
use common\models\VideoComment;
use common\models\VideoTypes;
use xj\uploadify\UploadAction;
use Yii;

class VideoController extends BackendController
{

    //关闭csrf 跨站检测攻击
    public $enableCsrfValidation = false;
    public function actions() {
        return [
            's-upload' => [
                'class' => UploadAction::className(),
                //存放的磁盘目录
                'basePath' => '@webroot/upload',
                //网站访问url
                'baseUrl' => '@web/upload',
                'enableCsrf' => true, // default
                'postFieldName' => 'Filedata', // default
                //BEGIN METHOD
                'format' => [$this, 'methodName'],
                'overwriteIfExist' => true,
                //不会创建更具体的文件夹
                /*'format' => function (UploadAction $action) {
                    $fileext = $action->uploadfile->getExtension();
                    $filename = sha1_file($action->uploadfile->tempName);
                    return "{$filename}.{$fileext}";
                },*/
                //END CLOSURE BY-HASH
                //BEGIN CLOSURE BY TIME
                //会创建更加具体的文件夹
                'format' => function (UploadAction $action) {
                    $fileext = $action->uploadfile->getExtension();
                    $filehash = sha1(uniqid() . time());
                    $p1 = date('Ymd', time());
                    return "{$p1}/{$filehash}.{$fileext}";
                },
                //END CLOSURE BY TIME
                'validateOptions' => [
                    'extensions' => ['jpg', 'png'],
                    'maxSize' => 1 * 1024 * 1024, //file size
                ],
                'beforeValidate' => function (UploadAction $action) {
                    //throw new Exception('test error');
                },
                'afterValidate' => function (UploadAction $action) {},
                'beforeSave' => function (UploadAction $action) {

                },
                'afterSave' => function (UploadAction $action) {
                    $action->output['fileUrl'] = $action->getWebUrl();
                    $action->output['savePath'] = $action->getSavePath();
                    //Image::thumbnail($action->getSavePath(), 100, 100, ManipulatorInterface::THUMBNAIL_INSET)->save();
                    /*                    $action->getFilename(); // "image/yyyymmddtimerand.jpg"
                                        $action->getWebUrl(); //  "baseUrl + filename, /upload/image/yyyymmddtimerand.jpg"
                                        $action->getSavePath(); // "/var/www/htdocs/upload/image/yyyymmddtimerand.jpg"*/
                    //Image::thumbnail($action->getWebUrl(), 345, 210 ,ManipulatorInterface::THUMBNAIL_INSET, 100);
                    //生成缩略图
//                    Image::thumbnail($action->getSavePath(), 750, 210, \Imagine\Image\ManipulatorInterface::THUMBNAIL_OUTBOUND)
//                        ->save($action->getSavePath(), ['quality' => 100]);
                },
            ]
        ];
    }

    //视频教程类型页面
    public function actionVideotypes()
    {
        $pidData = VideoTypes::find()->where(['pid'=>0])->asArray()->all();
        return $this->renderPartial('videotypes', ['pidData'=> $pidData]);
    }

    //获取视频教程类型列表
    public function actionVideotypeslist()
    {
        return json_encode(Videotypes::getVideotypesList(Yii::$app -> request -> post()));
    }

    //添加视频教程类型
    public function actionAddvideotypes()
    {
        if(Yii::$app -> request -> isPost) {
            echo Videotypes::addVideotypes(Yii::$app->request->post());
        }
    }

    //获取一条修改视频教程类型数据
    public function actionOnevideotypes()
    {
        $id = Yii::$app -> request -> post('id');
        return json_encode(Videotypes::oneVideotypes($id));
    }

    //修改一条视频教程类型数据
    public function actionEditvideotypes()
    {
        if(Yii::$app -> request -> isPost) {
            echo Videotypes::editVideotypes(Yii::$app->request->post());
        }
    }

    //删除视频教程类型数据
    public function actionDeletevideotypes()
    {
        if(Yii::$app -> request -> isPost) {
            echo Videotypes::deleteVideotypes(Yii::$app->request->post('ids'));
        }
    }

    //视频教程页面
    public function actionIndex()
    {
        return $this->renderPartial('index');
    }

    //获取视频教程列表
    public function actionVideolist()
    {
        return json_encode(Video::getVideoList(Yii::$app -> request -> post()));
    }

    //添加视频教程
    public function actionAddvideo()
    {
        $model = new Video();
        if(Yii::$app->request->isPost && $model->load(Yii::$app->request->post()) && $model->save()){
            Yii::$app->cache->delete('videoData');
            Yii::$app->session->setFlash('success' , '视频教程添加成功');
            return Yii::$app->response->redirect(['video/addvideo']);
        }
        return $this->render('addvideo',['model'=>$model]);
    }

    //修改视频教程
    public function actionEditvideo()
    {
        $id = Yii::$app->request->get('id' , 0);
        $model = Video::findOne($id);
        if(Yii::$app->request->isPost && $model->load(Yii::$app->request->post()) && $model->save()){
            Yii::$app->session->setFlash('success' , '视频教程修改成功');
            return Yii::$app->response->redirect(['video/editvideo','id'=>$id]);
        }
        return $this->render('editvideo' , ['model' => $model]);
    }

    //删除视频教程
    public function actionDeletevideo()
    {
        if(Yii::$app -> request -> isPost) {
            echo Video::deleteVideo(Yii::$app->request->post('ids'));
        }
    }

    //视频评论页面
    public function actionVideocomment()
    {
        return $this->renderPartial('videocomment');
    }

    //获取视频评论列表
    public function actionVideocommentlist()
    {
        return json_encode(VideoComment::getVideoCommentList(Yii::$app -> request -> post()));
    }

    //修改视频评论
    public function actionShowvideocomment()
    {
        $id = Yii::$app->request->get('id' , 0);
        $model = VideoComment::findOne($id);
        return $this->render('showvideocomment', ['model' => $model]);
    }

    //删除视频评论
    public function actionDeletevideocomment()
    {
        if(Yii::$app -> request -> isPost) {
            echo VideoComment::deleteVideoComment(Yii::$app->request->post('ids'));
        }
    }

















































}