<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/12/11
 * Time: 22:08
 */

namespace frontend\components;
use common\components\Helper;
use common\models\Leave;
use common\models\User;
use Yii;

class LeaveQry extends BaseQry
{

    /*
     * 新增留言
     * */
    public function addNologinLeave($post)
    {
        $content = $post['content'];
        $name = $post['name'];
        $mail = $post['mail'];
        if(mb_strlen($content, 'utf-8') < 5) {
            return -1;
        }
        if(mb_strlen($name, 'utf-8') == 0) {
            return -2;
        }
        if(mb_strlen($mail, 'utf-8') < 6) {
            return -3;
        }
        $model = new Leave();
        $model->content = htmlspecialchars($content);
        $model->name = $name;
        $model->mail = $mail;
        $addressData = Helper::getIpLookup(Yii::$app->request->getUserIP());
        if($addressData) {
            $model->address = $addressData['province'] .'-'.$addressData['city'];
        }
        if(Helper::isMobile()) {    //判断是pc端还是手机端
            $model->equipment = '1';
        } else {
            $model->equipment = '2';
        }
        $model->create_time = time();
        if($model->save()) {
            $model->create_time = date('Y-m-d H:i:s', $model->create_time);
            return $model->attributes;
        }
    }

    /*
     * 新增留言，登录
     * */
    public function addLoginLeave($post)
    {
        $content = $post['content'];
        if(mb_strlen($content, 'utf-8') < 5) {
            return -1;
        }
        $model = new Leave();
        $model->content = htmlspecialchars($content);
        $model->uid = Yii::$app->session->get(User::USER_ID);
        $addressData = Helper::getIpLookup(Yii::$app->request->getUserIP());
        if($addressData) {
            $model->address = $addressData['province'] .'-'.$addressData['city'];
        }
        if(Helper::isMobile()) {    //判断是pc端还是手机端
            $model->equipment = '1';
        } else {
            $model->equipment = '2';
        }
        if($model->save()) {
            $model->create_time = date('Y-m-d H:i:s', $model->attributes['create_time']);
            return $model->attributes;
        }
    }



    /*
     * 获取一篇技术博文的评论总数
     * */
    public function getLeaveCount()
    {
        return Leave::find()->where(['pid'=> 0, 'status'=> '1'])->count();
    }


    /*
     * 获取技术博文的评论
     * */
    public function getLeaveList($offset, $limit)
    {
        $data = Leave::find()->where(['pid'=> 0, 'status'=> '1'])->orderBy('create_time DESC')->offset($offset)->limit($limit)->asArray()->all();
        foreach($data as $key => $value) {
            if($value['uid']) {
                $data[$key]['uidcopy'] = User::find()->where(['id'=>$value['uid']])->asArray()->one();
            } else {
                $data[$key]['uidcopy'] = '匿名用户';
            }

            $data[$key]['childleave'] = Leave::find()->where(['pid'=>$value['id'], 'status'=> '1'])->orderBy('create_time ASC')->asArray()->all();
            foreach($data[$key]['childleave'] as $key2 => $value2) {
                if($value2['uid']) {
                    $data[$key]['childleave'][$key2]['uidcopy'] = User::find()->where(['id'=>$value2['uid']])->asArray()->one();
                } else {
                    $data[$key]['childleave'][$key2]['uidcopy'] = '匿名用户';
                }
            }
        }
        return $data;
    }


    /*
     * 发表评论
     * */
    public function publishResponse($content, $pid)
    {
        $model = new Leave();
        $model->pid = $pid;
        $model->uid = Yii::$app->session->get(User::USER_ID);
        $model->content = htmlspecialchars($content);
        $addressData = Helper::getIpLookup(Yii::$app->request->getUserIP());
        if($addressData) {
            $model->address = $addressData['province'] .'-'.$addressData['city'];
        }
        if(Helper::isMobile()) {    //判断是pc端还是手机端
            $model->equipment = '1';
        } else {
            $model->equipment = '2';
        }
        if($model->save()) {
            $model->create_time = date('Y-m-d H:i:s', $model->attributes['create_time']);
            return $model->attributes;
        }
    }














}