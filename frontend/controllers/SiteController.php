<?php
namespace frontend\controllers;

use common\components\Helper;
use common\models\Advice;
use common\models\Notice;
use common\models\User;
use frontend\components\ArticleQry;
use frontend\components\LinkCarQry;
use frontend\components\LinkQry;
use frontend\components\TechnologytypesQry;
use frontend\components\UserQry;
use Yii;
use yii\data\Pagination;
use yii\helpers\Url;

/**
 * Site controller
 */
class SiteController extends CommonController
{

    /*
     * 博客首页
     * */
    public function actionIndex()
    {
        if(Yii::$app->cache->get('notice')) {   //获取网站通知
            $notice = Yii::$app->cache->get('notice');
        } else {
            $notice = Notice::find()->where(['id'=> 1])->asArray()->one();
            Yii::$app->cache->set('notice', $notice);
        }


        $userData ='';
        $id = Yii::$app->request->get('id', 0);    //类型id
        $uid = Yii::$app->session->get(User::USER_ID);

        //分类列表
        if(Yii::$app->cache->get('technologyTypesData')) {  //获取缓存
            $techTypesData = Yii::$app->cache->get('technologyTypesData');
        } else {
            $techTypesData = TechnologytypesQry::getInstance()->getAllTypesList();
            Yii::$app->cache->set('technologyTypesData', $techTypesData);
        }

        //文章列表
        if(Yii::$app->cache->get('technologyPagination'.$id)) {  //获取缓存
            $pagination = Yii::$app->cache->get('technologyPagination'.$id);
        } else {
            $pagination = new Pagination(['totalCount'=>ArticleQry::getInstance()->getTechnologyCount($id),'pageSize'=>10]);
            Yii::$app->cache->set('technologyPagination'.$id, $pagination, 86400);
        }
        if(Yii::$app->cache->get('technologyDataoffset'.$pagination->offset.'id'.$id)) {  //获取缓存
            $technologyData = Yii::$app->cache->get('technologyDataoffset'.$pagination->offset.'id'.$id);
        } else {
            $technologyData = ArticleQry::getInstance()->getTechnologyList($id,$pagination->offset,$pagination->limit);
            Yii::$app->cache->set('technologyDataoffset'.$pagination->offset.'id'.$id, $technologyData, 86400);
        }



        //热门文章列表
        if(Yii::$app->cache->get('hotsData')) {  //获取缓存
            $hotsData = Yii::$app->cache->get('hotsData');
        } else {
            $hotsData = ArticleQry::getInstance()->getHotsList(10);
            Yii::$app->cache->set('hotsData', $hotsData);
        }

        if($uid) {
            //用户资料
            $userData = User::find()->where(['id'=> Yii::$app->session->get(User::USER_ID)])->asArray()->one();
        }

        //友情链接列表
        $linkData = LinkQry::getInstance()->getLinkList();

        //直通车列表
        $linkCarData = LinkCarQry::getInstance()->getLinkCarList();

        return $this->render('index', ['notice'=> $notice, 'userData'=> $userData,'technologyData'=> $technologyData,'techTypesData'=> $techTypesData,'hotsData'=> $hotsData,'linkData'=> $linkData,'linkCarData'=> $linkCarData,'pagination'=>$pagination]);
    }

    /*
     * 登录页面
     * */
    public function actionLogin()
    {
        $model = new User();
        if(Yii::$app->request->isPost) {
            $model->load(Yii::$app->request->post());
            $result = $model->login();
            if($result > 0) {
                return $this->redirect(['site/index']);
            } else if ($result == -1) {
                $forgetAddress = Url::to(['site/forget']);
                Yii::$app->session->setFlash('error' , "很遗憾，帐号或密码输入错误&nbsp;<a href='$forgetAddress' target='_blank'>找回密码 &gt;&gt;</a>");
                return $this->redirect(['site/login']);
            } else if ($result == -2) {
                Yii::$app->session->setFlash('error' , '很遗憾，您的帐号已被冻结，请联系管理员解封');
                return $this->redirect(['site/login']);
            }
        }
        return $this->render('login', ['model'=> $model]);
    }

    /*
     * 注册页面
     * */
    public function actionRegister()
    {
        $model = new User();
        if(Yii::$app->request->isPost) {
            $model->face = $model->saveFace($_FILES['face']);
            if($model->load(Yii::$app->request->post()) && $model->save()) {
                $loginUrl = Url::to(['site/login']);
                Yii::$app->session->setFlash('success' , "恭喜你，用户注册成功");
                return $this->redirect(['site/login']);
            }
        }
        return $this->render('register', ['model'=> $model]);
    }

    /*
     * 搜索功能
     * */
    public function actionSearch()
    {
        $userData ='';
        $keyword = Yii::$app->request->get('keyword');
        $uid = Yii::$app->session->get(User::USER_ID);
        if(empty($keyword)) {
            return $this->redirect(['site/index']);
        }

        //分类列表
        if(Yii::$app->cache->get('technologyTypesData')) {  //获取缓存
            $techTypesData = Yii::$app->cache->get('technologyTypesData');
        } else {
            $techTypesData = TechnologytypesQry::getInstance()->getAllTypesList();
            Yii::$app->cache->set('technologyTypesData', $techTypesData);
        }

        //文章列表
        $pagination = new Pagination(['totalCount'=>ArticleQry::getInstance()->getSearchCount($keyword),'pageSize'=>10]);
        $searchData = ArticleQry::getInstance()->getSearchList($keyword,$pagination->offset,$pagination->limit);

        //热门文章列表
        if(Yii::$app->cache->get('hotsData')) {  //获取缓存
            $hotsData = Yii::$app->cache->get('hotsData');
        } else {
            $hotsData = ArticleQry::getInstance()->getHotsList(10);
            Yii::$app->cache->set('hotsData', $hotsData);
        }

        if($uid) {
            //用户资料
            $userData = User::find()->where(['id' => $uid])->asArray()->one();

        }
        return $this->render('search', ['userData'=> $userData,'searchData'=> $searchData,'techTypesData'=> $techTypesData,'hotsData'=> $hotsData,'pagination'=>$pagination]);
    }

    /*
     * 用户加载头像
     * */
    public function actionCheckface()
    {
        $faceData = UserQry::getInstance()->checkFace(Yii::$app->request->post('account'));
        if($faceData) {
            echo base64_decode($faceData);
        } else {
            echo -1;
        }
    }

    /*
     * 用户找回密码页面
     * */
    public function actionForget()
    {
        if(Yii::$app->request->isPost) {
            $account = Yii::$app->request->post('account');
            $email = Yii::$app->request->post('mail');
            $result = UserQry::getInstance()->findPassword($account, $email);
            if($result > 0) {   //信息验证成功，发送邮件
                $nowtime = time();
                $user = [
                    'account' => $account,
                    'active_token' => base64_encode($account.$nowtime.md5($nowtime)),
                ];
                $mail = Yii::$app->mailer;
                $mail->useFileTransport = false;
                $mail= $mail->compose('findpassword-html' , ['user' => $user]);
                $mail->setTo($email);
                $mail->setSubject("感谢来到amgo官方博客，请验证您的email");
                //$mail->setTextBody('Test content');
                if($mail->send()){
                    $mailSuffix = explode('@' , $email)[1];
                    $mailUrl = Helper::getMailAddress($mailSuffix);     //根据邮箱后缀得到邮箱登录地址
                    Yii::$app->session->setFlash('success' , "亲爱的用户，我们已将重置密码的邮件发送至您的邮箱，请注意查收，<a href='$mailUrl' target='_blank'>进入邮箱 &gt;&gt;</a>");
                    return Yii::$app->response->redirect(['site/forget']);
                }
            } else if ($result == -1) {
                Yii::$app->session->setFlash('error' , '亲爱的用户，你输入的信息不正确！');
                return Yii::$app->response->redirect(['site/forget']);
            } else if ($result == -2) {
                Yii::$app->session->setFlash('error' , '您的帐号已经被管理员冻结，请直接联系管理员解封！');
                return Yii::$app->response->redirect(['site/forget']);
            } else {
                Yii::$app->session->setFlash('error' , '很遗憾，发生了未知错误，请刷新后重试！');
                return Yii::$app->response->redirect(['site/forget']);
            }
        }
        return $this->render('forget');
    }

    /*
     * 充值密码页面
     * */
    public function actionResetpassword()
    {
        $oactiveToken = Yii::$app->request->get('activeToken');
        $activeToken = base64_decode($oactiveToken);
        $data = mb_substr($activeToken, 0, -32);
        $accountdata = mb_substr($data, 0, -10);
        $timedata = mb_substr($data, -10);
        if(time() - $timedata >= 600) {  //邮件时间超过10分钟就失效
            $homeUrl = Url::to(['site/index']);
            echo "重置密码邮件已经失效，<a href='$homeUrl'>返回首页 &gt; &gt;</a>";
            exit();
        } else {
            $userData = User::find()->where(['account'=> $accountdata, 'status'=> 1])->asArray()->one();
            if($userData) {
                $model = User::findOne($userData['id']);
                $model->password = '';
                if(Yii::$app->request->isPost) {
                    $result = UserQry::getInstance()->resetPassword($model->id, Yii::$app->request->post('User'));
                    if($result > 0) {
                        Yii::$app->session->setFlash('success' , "恭喜您，密码重置成功。");
                        return Yii::$app->response->redirect(['site/login', 'activeToken'=> $oactiveToken]);
                    } else {
                        Yii::$app->session->setFlash('error' , "密码重置失败，密码至少要6字符");
                        return Yii::$app->response->redirect(['site/resetpassword', 'activeToken'=> $oactiveToken]);
                    }
                }
                return $this->render('resetpassword', ['model'=> $model]);
            } else {
                $homeUrl = Url::to(['site/index']);
                echo "重置密码邮件已经失效，<a href='$homeUrl'>返回首页 &gt; &gt;</a>";
                exit();
            }

        }
    }

    /*
     * 错误页面
     * */
    public function actionError()
    {
        return $this->render('error');
    }

    /*
     * 用户名检测
     * */
    public function actionCheckaccount()
    {
        $account = Yii::$app->request->post('account');
        if(UserQry::getInstance()->getUserByAccount($account)) {
            return false;
        } else {
            return true;
        }
    }





    public function actionTest()
    {
        $account = '15695900787';
        $user = [
            'account' => $account,
            'active_token' => base64_encode($account.'www.amgogo.com'),
        ];
        $mail = Yii::$app->mailer;
        $mail->useFileTransport = false;
        $mail= $mail->compose('findpassword-html' , ['user' => $user]);
        $mail->setTo('1228550493@qq.com');
        $mail->setSubject("感谢来到amgo官方博客，请验证您的email");
        //$mail->setTextBody('Test content');
        if($mail->send()){
            return $this->render('waiting' , ['user' => $user]);
        }
    }






























}
