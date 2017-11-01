<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/12/4
 * Time: 18:15
 */

namespace frontend\controllers;

use common\models\Advice;
use common\models\Link;
use Yii;
class ComplexController extends CommonController
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

    /*
     * 友情链接申请页面
     * */
    public function actionApplylink()
    {
        $model = new Link();
        if(Yii::$app->request->isPost && $model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success' , '恭喜您，友情链接申请已经提交，审核结果以邮件的方式通知！');
            return Yii::$app->response->redirect(['complex/applylink']);
        }
        return $this->render('applylink', ['model'=> $model]);
    }


    /*
     * 用户反馈信息页面
     * */
    public function actionAdvice()
    {
        $model = new Advice();
        if(Yii::$app->request->isPost && $model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success' , '感谢您的反馈，博主看见后会马上给您回复，谢谢！');
            return Yii::$app->response->redirect(['complex/advice']);
        }
        return $this->render('advice', ['model'=> $model]);
    }







}