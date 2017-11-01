<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/11/16 0016
 * Time: 16:20
 */

namespace frontend\controllers;

use frontend\components\ArticleQry;
use frontend\components\UserQry;
use Yii;
use common\models\User;
use yii\data\Pagination;

class UserController extends FrontendController
{

    /*
     * 用户的个人中心
     * */
    public function actionMember()
    {
        $uid = Yii::$app->session->get(User::USER_ID);
        //获取我的个人资料
        $userData = User::find()->where(['id'=> Yii::$app->session->get(User::USER_ID)])->asArray()->one();
        //获取回复我的
        $responsePagination = new Pagination(['totalCount'=>ArticleQry::getInstance()->getResponseCount($uid),'pageSize'=>20]);
        $responseData = ArticleQry::getInstance()->getResponseList($uid, $responsePagination->offset, $responsePagination->limit);
        //获取我赞过的内容
        $likePagination = new Pagination(['totalCount'=>ArticleQry::getInstance()->getLikeCount($uid),'pageSize'=>20]);
        $likeData = ArticleQry::getInstance()->getLikeArticleList($uid, $likePagination->offset, $likePagination->limit);
        //获取我评论过的内容
        $commentPagination = new Pagination(['totalCount'=>ArticleQry::getInstance()->getCommentCount($uid),'pageSize'=>20]);
        $commentData = ArticleQry::getInstance()->getCommentArticleList($uid, $commentPagination->offset, $commentPagination->limit);
        //获取最近浏览过的
        $readData = ArticleQry::getInstance()->getReadArticleList($uid);
        //热门文章列表
        if(Yii::$app->cache->get('hotsData')) {  //获取缓存
            $hotsData = Yii::$app->cache->get('hotsData');
        } else {
            $hotsData = ArticleQry::getInstance()->getHotsList(10);
            Yii::$app->cache->set('hotsData', $hotsData);
        }
        return $this->render('member', ['userData'=> $userData, 'likeData'=> $likeData, 'hotsData'=> $hotsData, 'responseData'=> $responseData, 'commentData'=> $commentData, 'readData'=> $readData, 'responsePagination'=> $responsePagination, 'likePagination'=> $likePagination, 'commentPagination'=> $commentPagination]);
    }

    /*
     * 编辑用户资料
     * */
    public function actionEdit()
    {
        $session = Yii::$app->session;
        $uid = $session->get(User::USER_ID);
        $model = User::findOne($uid);
        if(Yii::$app->request->isPost) {
            $faceData = $model->saveFace($_FILES['face']);
            $result = $model->editUser($uid, Yii::$app->request->post('User'), $faceData);
            if($result) {
                //资料修改成功之后更新session
                $session->remove(User::USER_ACCOUNT);
                $session->remove(User::USER_FACE);
                $userData = User::find()->where(['id'=> $uid])->asArray()->one();
                $session->set(User::USER_ACCOUNT, $userData['account']);
                $session->set(User::USER_FACE, base64_decode($userData['face']));
                Yii::$app->session->setFlash('success' , '恭喜你，用户资料修改成功！');
                return $this->redirect(['user/edit']);
            } else {
                Yii::$app->session->setFlash('error' , '很遗憾，原密码输入错误！');
                return $this->redirect(['user/edit']);
            }
        }
        $model->password = '';
        return $this->render('edit', ['model'=> $model]);
    }

    /*
     * 用户退出
     * */
    public function actionLogout()
    {
        $model = new User();
        if($model->logout()){
            return $this->redirect(['site/index']);
        }
    }
















}