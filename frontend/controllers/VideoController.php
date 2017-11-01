<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/10/28 0028
 * Time: 9:38
 */

namespace frontend\controllers;

use common\models\User;
use common\models\Video;
use frontend\components\VideoQry;
use Yii;
use yii\data\Pagination;

class VideoController extends CommonController
{

    /*
     * 视频课程页面
     * */
    public function actionCourse()
    {
        if(Yii::$app->cache->get('videoData')) {  //获取缓存
            $videoData = Yii::$app->cache->get('videoData');
        } else {
            $videoData = Video::find()->where(['status'=> 1])->asArray()->all();
            Yii::$app->cache->set('videoData', $videoData);
        }
        return $this->render('course', ['videoData'=> $videoData]);
    }


    /*
     * 视频详情
     * */
    public function actionDetails()
    {

        $vid = Yii::$app->request->get('id');
        //文章
        $detailsData = VideoQry::getInstance()->getVideoDetails($vid);
        //评论
        $pagination = new Pagination(['totalCount'=>VideoQry::getInstance()->getVideoCommentsCount($vid),'pageSize'=>10]);
        $commentData = VideoQry::getInstance()->getVideoComments($vid,$pagination->offset,$pagination->limit);
        //登录用户资料
        $userData = '';
        if($this->userId && $this->userAccount) {
            $userData = User::find()->where(['id'=> $this->userId])->asArray()->one();
        }
        return $this->render('details', ['userData'=> $userData,'detailsData'=> $detailsData,'commentData'=> $commentData,'pagination'=>$pagination]);
    }


    /*
     * 发表评论
     * */
    public function actionComment()
    {
        if(Yii::$app->request->isAjax) {
            $tid = Yii::$app->request->post('tid');
            $pid = Yii::$app->request->post('pid') == '' ? '0' : Yii::$app->request->post('pid');
            $content = Yii::$app->request->post('content');
            echo json_encode(VideoQry::getInstance()->publishComment($tid, $content, $pid));
        }
    }















}