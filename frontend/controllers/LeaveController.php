<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/12/5
 * Time: 22:53
 */

namespace frontend\controllers;


use common\models\Leave;
use common\models\User;
use frontend\components\ArticleQry;
use frontend\components\LeaveQry;
use frontend\components\LinkCarQry;
use frontend\components\LinkQry;
use yii\data\Pagination;
use Yii;
class LeaveController extends CommonController
{

    public function actionIndex()
    {
        $model = new Leave();
        //评论
        $pagination = new Pagination(['totalCount'=>LeaveQry::getInstance()->getLeaveCount(),'pageSize'=>10]);
        $leaveData = LeaveQry::getInstance()->getLeaveList($pagination->offset,$pagination->limit);

        //登录用户资料
        $userData = '';
        if($this->userId && $this->userAccount) {
            $userData = User::find()->where(['id'=> $this->userId])->asArray()->one();
        }

        //热门文章列表
        if(Yii::$app->cache->get('hotsData')) {  //获取缓存
            $hotsData = Yii::$app->cache->get('hotsData');
        } else {
            $hotsData = ArticleQry::getInstance()->getHotsList(10);
            Yii::$app->cache->set('hotsData', $hotsData);
        }

        //友情链接列表
        $linkData = LinkQry::getInstance()->getLinkList();

        //直通车列表
        $linkCarData = LinkCarQry::getInstance()->getLinkCarList();

        return $this->render('index', ['model'=> $model,'userData'=> $userData,'leaveData'=> $leaveData,'hotsData'=> $hotsData,'linkData'=> $linkData,'linkCarData'=> $linkCarData,'pagination'=>$pagination]);
    }


    /*
     * 新增留言，匿名
     * */
    public function actionNologinadd()
    {
        if(Yii::$app->request->isAjax) {
            echo json_encode(LeaveQry::getInstance()->addNologinLeave(Yii::$app->request->post()));
        }
    }

    /*
     * 新增留言，登录
     * */
    public function actionLoginadd()
    {
        if(Yii::$app->request->isAjax) {
            echo json_encode(LeaveQry::getInstance()->addLoginLeave(Yii::$app->request->post()));
        }
    }


    /*
     * 回复留言
     * */
    public function actionResponse()
    {
        if(Yii::$app->request->isAjax) {
            $pid = Yii::$app->request->post('pid') == '' ? '0' : Yii::$app->request->post('pid');
            $content = Yii::$app->request->post('content');
            echo json_encode(LeaveQry::getInstance()->publishResponse($content, $pid));
        }
    }














}