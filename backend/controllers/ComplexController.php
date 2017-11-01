<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/11/19
 * Time: 20:53
 */

namespace backend\controllers;
use common\models\LinkCar;
use xj\uploadify\UploadAction;
use common\models\Link;
use Yii;
use common\models\Advice;

class ComplexController extends BackendController
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
            ],
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

    /*
     * 用户反馈页面
     * */
    public function actionAdvice()
    {
        return $this->renderPartial('advice');
    }

    /*
     * 获取用户反馈列表
     * */
    public function actionAdvicelist()
    {
        return json_encode(Advice::getAdviceList(Yii::$app -> request -> post()));
    }

    //回复用户反馈
    public function actionResponseadvice()
    {
        if(Yii::$app -> request -> isPost) {
            echo Advice::responseAdvice(Yii::$app->request->post('ids'));
        }
    }

    //删除用户反馈数据
    public function actionDeleteadvice()
    {
        if(Yii::$app -> request -> isPost) {
            echo Advice::deleteAdvice(Yii::$app->request->post('ids'));
        }
    }

    //查看详细反馈内容
    public function actionDetailsadvice()
    {
        $id = Yii::$app->request->get('id' , 0);
        $model = Advice::findOne($id);
        return $this->render('detailsadvice', ['model' => $model]);
    }

    //友情链接列表
    public function actionLink()
    {
        return $this->renderPartial('link');
    }

    /*
     * 获取友情链接列表
     * */
    public function actionLinklist()
    {
        return json_encode(Link::getLinkList(Yii::$app -> request -> post()));
    }

    //添加友情链接
    public function actionAddlink()
    {
        $model = new Link();
        if(Yii::$app->request->isPost && $model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->cache->delete('link'); //删除缓存
            Yii::$app->session->setFlash('success' , '友情链接新增成功');
            return Yii::$app->response->redirect(['complex/addlink']);
        }
        return $this->render('addlink', ['model'=> $model]);
    }

    //删除友情链接数据
    public function actionDeletelink()
    {
        if(Yii::$app -> request -> isPost) {
            echo Link::deleteLink(Yii::$app->request->post('ids'));
        }
    }

    //编辑友情链接
    public function actionEditlink()
    {
        $id = Yii::$app->request->get('id' , 0);
        $model = Link::findOne($id);
        if(Yii::$app->request->isPost && $model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->cache->delete('link'); //删除缓存
            Yii::$app->session->setFlash('success' , '友情链接修改成功');
            return Yii::$app->response->redirect(['complex/editlink', 'id'=> $id]);
        }
        return $this->render('editlink', ['model' => $model]);
    }

    //直通车列表
    public function actionLinkcar()
    {
        return $this->renderPartial('linkcar');
    }

    /*
     * 获取直通车列表
     * */
    public function actionLinkcarlist()
    {
        return json_encode(LinkCar::getLinkCarList(Yii::$app -> request -> post()));
    }

    //添加直通车
    public function actionAddlinkcar()
    {
        $model = new LinkCar();
        if(Yii::$app->request->isPost && $model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->cache->delete('link'); //删除缓存
            Yii::$app->session->setFlash('success' , '直通车新增成功');
            return Yii::$app->response->redirect(['complex/addlinkcar']);
        }
        return $this->render('addlinkcar', ['model'=> $model]);
    }

    //删除直通车数据
    public function actionDeletelinkcar()
    {
        if(Yii::$app -> request -> isPost) {
            echo LinkCar::deleteLinkCar(Yii::$app->request->post('ids'));
        }
    }

    //编辑直通车
    public function actionEditlinkcar()
    {
        $id = Yii::$app->request->get('id' , 0);
        $model = LinkCar::findOne($id);
        if(Yii::$app->request->isPost && $model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->cache->delete('link'); //删除缓存
            Yii::$app->session->setFlash('success' , '直通车修改成功');
            return Yii::$app->response->redirect(['complex/editlinkcar', 'id'=> $id]);
        }
        return $this->render('editlinkcar', ['model' => $model]);
    }













}