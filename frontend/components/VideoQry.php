<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/5/29
 * Time: 7:19
 */

namespace frontend\components;
use common\components\Helper;
use common\models\TechnologyTypes;
use common\models\User;
use common\models\Video;
use common\models\VideoComment;
use Yii;


class VideoQry extends BaseQry
{

    /*
     * 获取一篇技术博文详情
     * */
    public function getVideoDetails($tid)
    {
        $data = Video::find()->where(['id'=>$tid])->asArray()->one();
        //过滤
        return $this->getInstance()->setVideoFilter($data);
    }


    /*
     * 发表评论
     * */
    public function publishComment($tid, $content, $pid)
    {
        $model = new VideoComment();
        $model->tid = $tid;
        $model->pid = $pid;
        $model->uid = Yii::$app->session->get(User::USER_ID);
        $model->content = htmlspecialchars($content);
        $model->create_time = time();
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
            $model->create_time = date('Y-m-d H:i:s', $model->create_time);
            return $model->attributes;
        }
    }

    /*
     * 获取技术博文的评论
     * */
    public function getVideoComments($tid, $offset, $limit)
    {
        $data = VideoComment::find()->where(['tid'=>$tid, 'pid'=> 0])->orderBy('create_time DESC')->offset($offset)->limit($limit)->asArray()->all();
        foreach($data as $key => $value) {
            $data[$key]['uidcopy'] = User::find()->where(['id'=>$value['uid']])->asArray()->one();
            $data[$key]['childcomment'] = VideoComment::find()->where(['pid'=>$value['id']])->orderBy('create_time ASC')->asArray()->all();
            foreach($data[$key]['childcomment'] as $key2 => $value2) {
                $data[$key]['childcomment'][$key2]['uidcopy'] = User::find()->where(['id'=>$value2['uid']])->asArray()->one();
            }
        }
        return $data;
    }

    /*
     * 获取一篇技术博文的评论总数
     * */
    public function getVideoCommentsCount($tid)
    {
        return VideoComment::find()->where(['tid'=>$tid, 'pid'=> 0])->count();
    }

    /*
     * 过滤文章，获取   点赞，阅读，评论，类型
     * */
    public function setVideoFilter($data)
    {
        if(count($data) > 0 ) {
            if(count($data) == count($data, 1)) {
                $data['commentcount'] = VideoComment::find()->where(['tid'=>$data['id']])->count();
                $data['typescopy'] = TechnologyTypes::find()->where(['id'=>$data['types']])->asArray()->one()['title'];
            } else {
                foreach($data as $key => $value) {
                    $data[$key]['commentcount'] = VideoComment::find()->where(['tid'=>$value['id']])->count();
                    $data[$key]['typescopy'] = TechnologyTypes::find()->where(['id'=>$value['types']])->asArray()->one()['title'];
                }
            }
        }
        return $data;
    }



































}