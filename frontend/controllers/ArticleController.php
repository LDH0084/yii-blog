<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/10/28 0028
 * Time: 9:29
 */

namespace frontend\controllers;

use common\models\User;
use frontend\components\ArticleQry;
use Yii;
use yii\data\Pagination;

class ArticleController extends CommonController
{

    /*
     * 技术博文页面
     * */
    public function actionTechnology()
    {
        $id = Yii::$app->request->get('id');    //类型id
        $pagination = new Pagination(['totalCount'=>ArticleQry::getInstance()->getTechnologyCount($id),'pageSize'=>10]);
        $technologyData = ArticleQry::getInstance()->getTechnologyList($id,$pagination->offset,$pagination->limit);
        return $this->render('technology', ['technologyData'=> $technologyData,'pagination'=>$pagination]);
    }

    /*
     * 技术博文详情页面
     * */
    public function actionTechnologydetails()
    {
        $tid = Yii::$app->request->get('id');
        //阅读数据写入数据库
        ArticleQry::getInstance()->setTechnologyRead($tid);
        //文章
        $detailsData = ArticleQry::getInstance()->getTechnologyDetails($tid);
        //评论
        $pagination = new Pagination(['totalCount'=>ArticleQry::getInstance()->getTechnologyCommentsCount($tid),'pageSize'=>10]);
        $commentData = ArticleQry::getInstance()->getTechnologyComments($tid,$pagination->offset,$pagination->limit);
        //登录用户资料
        $userData = '';
        if($this->userId && $this->userAccount) {
            $userData = User::find()->where(['id'=> $this->userId])->asArray()->one();
        }
        return $this->render('details', ['userData'=> $userData,'detailsData'=> $detailsData,'commentData'=> $commentData,'pagination'=>$pagination]);
    }

    /*
     * 文章点赞
     * */
    public function actionLike()
    {
        if(Yii::$app->request->isAjax) {
            if(Yii::$app->session->has(User::USER_ID) && Yii::$app->session->has(User::USER_ACCOUNT)) {
                $tid = Yii::$app->request->post('tid');
                $uid = Yii::$app->session->get(User::USER_ID);
                echo ArticleQry::getInstance()->setTechnologyLike($tid, $uid);
            } else {
                echo -2;
            }
        }
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
            echo json_encode(ArticleQry::getInstance()->publishComment($tid, $content, $pid));
        }
    }











}