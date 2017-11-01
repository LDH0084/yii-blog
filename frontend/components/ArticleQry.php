<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/5/29
 * Time: 7:19
 */

namespace frontend\components;


use common\components\Helper;
use common\models\Technology;
use common\models\TechnologyComment;
use common\models\TechnologyExtend;
use common\models\TechnologyTypes;
use common\models\User;
use Yii;
use yii\helpers\ArrayHelper;


class ArticleQry extends BaseQry
{

    /*
     * 获取热门文章列表
     * 热门为：评论次数，点赞次数之和
     * */
    public function getHotsList($limit)
    {
        //$sql = "SELECT TOP(10) * FROM {{%technology_extend}}";
        return Technology::find()->where(['status'=>1])->orderBy('hots DESC')->limit($limit)->asArray()->all();
    }

    /*
     * 获取技术博文列表
     * */
    public function getTechnologyList($id, $offset, $limit)
    {
        if(empty($id)) {
            $data = Technology::find()->where(['status'=>1])->orderBy('create_time DESC')->offset($offset)->limit($limit)->asArray()->all();
        } else {
            //判断是否为主类型
            $data2 = TechnologyTypes::find()->where(['id'=>$id,'pid'=> 0])->one();
            if(empty($data2)) {
                $data = Technology::find()->where(['status'=>1,'types'=>$id])->orderBy('create_time DESC')->offset($offset)->limit($limit)->asArray()->all();
            } else {
                //找出所有的子节点id
                $idarr = ArrayHelper::getColumn(TechnologyTypes::find()->where(['pid'=>$id])->select('id')->asArray()->all(), 'id');
                $data = Technology::find()->where(['status'=>1])->andWhere(['in','types', $idarr])->orderBy('create_time DESC')->offset($offset)->limit($limit)->asArray()->all();
            }
        }
        //过滤
        return $this->getInstance()->setArticleFilter($data);
    }

    /*
     * 获取搜索的技术博文列表
     * */
    public function getSearchList($keyword, $offset, $limit)
    {
        $data = Technology::find()->where(['status'=>1])->andWhere(['like','title',$keyword])->orderBy('create_time DESC')->offset($offset)->limit($limit)->asArray()->all();
        foreach($data as $key => $value) {
            $data[$key]['title'] = preg_replace('/'.$keyword.'/i','<strong class="keyword">'.$keyword.'</strong>', $value['title']);
        }
        //过滤
        return $this->getInstance()->setArticleFilter($data);
    }

    /*
     * 获取一篇技术博文详情
     * */
    public function getTechnologyDetails($tid)
    {
        $data = Technology::find()->where(['id'=>$tid])->asArray()->one();
        //过滤
        return $this->getInstance()->setArticleFilter($data);
    }

    /*
     * 获取技术博文的评论
     * */
    public function getTechnologyComments($tid, $offset, $limit)
    {
        $data = TechnologyComment::find()->where(['tid'=>$tid, 'pid'=> 0])->orderBy('create_time DESC')->offset($offset)->limit($limit)->asArray()->all();
        foreach($data as $key => $value) {
            $data[$key]['uidcopy'] = User::find()->where(['id'=>$value['uid']])->asArray()->one();
            $data[$key]['childcomment'] = TechnologyComment::find()->where(['pid'=>$value['id']])->orderBy('create_time ASC')->asArray()->all();
            foreach($data[$key]['childcomment'] as $key2 => $value2) {
                $data[$key]['childcomment'][$key2]['uidcopy'] = User::find()->where(['id'=>$value2['uid']])->asArray()->one();
            }
        }
        return $data;
    }

    /*
     * 获取技术博文总数
     * */
    public function getTechnologyCount($id)
    {
        if(empty($id)) {
            return Technology::find()->where(['status'=>1])->count();
        } else {
            //判断是否为主类型
            $data2 = TechnologyTypes::find()->where(['id'=>$id,'pid'=> 0])->one();
            if(empty($data2)) {
                return Technology::find()->where(['status'=>1,'types'=>$id])->count();
            } else {
                //找出所有的子节点id
                $idarr = ArrayHelper::getColumn(TechnologyTypes::find()->where(['pid'=>$id])->select('id')->asArray()->all(), 'id');
                return Technology::find()->where(['status'=>1])->andWhere(['in','types', $idarr])->count();
            }
        }
    }

    /*
     * 获取搜索的技术博文总数
     * */
    public function getSearchCount($keyword)
    {
        return Technology::find()->where(['status'=>1])->andWhere(['like','title',$keyword])->count();
    }

    /*
     * 获取一篇技术博文的评论总数
     * */
    public function getTechnologyCommentsCount($tid)
    {
        return TechnologyComment::find()->where(['tid'=>$tid, 'pid'=> 0])->count();
    }

    /*
     * 阅读数据写入数据库
     * */
    public function setTechnologyRead($tid)
    {
        $uid = Yii::$app->session->get(User::USER_ID);
        $nowtime = time();
        if($uid) {
            $sql = "INSERT INTO {{%technology_extend}} (tid, uid, isread, create_time) VALUES ('$tid', '$uid', 1, $nowtime)";
        } else {
            $sql = "INSERT INTO {{%technology_extend}} (tid, isread, create_time) VALUES ('$tid', 1, $nowtime)";
        }
        return Yii::$app->db->createCommand($sql)->execute();
    }

    /*
     * 技术博文点赞
     * 同一篇文章每天仅可点赞一次
     * */
    public function setTechnologyLike($tid, $uid)
    {
        $data = TechnologyExtend::find()->where(['tid'=>$tid, 'uid'=>$uid, 'issupport'=> 1])->orderBy('create_time DESC')->asArray()->one();
        if($data) {
            if(date('Y-m-d', $data['create_time']) == date('Y-m-d')) {
                return -1;
            }
        }
        $nowtime = time();
        $sql = "INSERT INTO {{%technology_extend}} (tid, uid, issupport, create_time) VALUES ('$tid', '$uid', 1, $nowtime)";
        if(Yii::$app->db->createCommand($sql)->execute()) {
            //文章的热度+1
            $sql2 = "UPDATE {{%technology}} SET hots = hots +1 WHERE id = '$tid'";
            return Yii::$app->db->createCommand($sql2)->execute();
        }
    }

    /*
     * 发表评论
     * */
    public function publishComment($tid, $content, $pid)
    {
        $model = new TechnologyComment();
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
            //文章的热度+1
            $sql1 = "UPDATE {{%technology}} SET hots = hots +1 WHERE id = '$tid'";
            Yii::$app->db->createCommand($sql1)->execute();

            $model->create_time = date('Y-m-d H:i:s', $model->create_time);
            return $model->attributes;
        }
    }

    /*
     * 过滤文章，获取   点赞，阅读，评论，类型
     * */
    public function setArticleFilter($data)
    {
        if(count($data) > 0 ) {
            if(count($data) == count($data, 1)) {
                $data['likecount'] = TechnologyExtend::find()->where(['tid'=>$data['id'], 'issupport'=> 1])->count();
                $data['commentcount'] = TechnologyComment::find()->where(['tid'=>$data['id']])->count();
                $data['typescopy'] = TechnologyTypes::find()->where(['id'=>$data['types']])->asArray()->one()['title'];
                $data['readcount'] = TechnologyExtend::find()->where(['tid'=>$data['id'], 'isread'=> 1])->count();
            } else {
                foreach($data as $key => $value) {
                    $data[$key]['likecount'] = TechnologyExtend::find()->where(['tid'=>$value['id'], 'issupport'=> 1])->count();
                    $data[$key]['commentcount'] = TechnologyComment::find()->where(['tid'=>$value['id']])->count();
                    $data[$key]['typescopy'] = TechnologyTypes::find()->where(['id'=>$value['types']])->asArray()->one()['title'];
                    $data[$key]['readcount'] = TechnologyExtend::find()->where(['tid'=>$value['id'], 'isread'=> 1])->count();
                }
            }
        }
        return $data;
    }

    /*
     * 获取我赞过的技术博文
     * */
    public function getLikeArticleList($uid, $offset, $limit)
    {
        $data = TechnologyExtend::find()->where(['uid'=> $uid, 'issupport'=> 1])->offset($offset)->limit($limit)->orderBy('create_time DESC')->asArray()->all();
        if($data) {
            foreach($data as $key => $value) {
                $data[$key]['tidcopy'] = Technology::find()->where(['id'=> $value['tid']])->asArray()->one();
            }
        }
        return $data;
    }

    /*
     * 获取我赞过的技术博文数量
     * */
    public function getLikeCount($uid)
    {
        return TechnologyExtend::find()->where(['uid'=> $uid, 'issupport'=> 1])->count();
    }

    /*
     * 获取回复我的技术博文
     * */
    public function getResponseList($uid, $offset, $limit)
    {
        $data = TechnologyComment::find()->where(['uid'=> $uid, 'pid'=> 0])->asArray()->all();
        if(empty($data)) {
            return $data;
        }
        $responseStr = '';
        foreach($data as $key => $value) {
            $responseStr .= $value['id'] . ',';
        }
        $responseStr = mb_substr($responseStr, 0 ,-1);
        $responseArr = explode(',', $responseStr);
        $data2 = TechnologyComment::find()->where(['in', 'pid', $responseArr])->orderBy('create_time DESC')->offset($offset)->limit($limit)->asArray()->all();
        foreach($data2 as $key => $value) {
            $data2[$key]['tidcopy'] = Technology::find()->where(['id'=> $value['tid']])->asArray()->one();
            $data2[$key]['uidcopy'] = User::find()->where(['id'=> $value['uid']])->asArray()->one();
        }
        return $data2;
    }

    /*
     * 获取回复我的技术博文数量
     * */
    public function getResponseCount($uid)
    {
        $data = TechnologyComment::find()->where(['uid'=> $uid, 'pid'=> 0])->asArray()->all();
        if(empty($data)) {
            return $data;
        }
        $responseStr = '';
        foreach($data as $key => $value) {
            $responseStr .= $value['id'] . ',';
        }
        $responseStr = mb_substr($responseStr, 0 ,-1);
        $responseArr = explode(',', $responseStr);
        return TechnologyComment::find()->where(['in', 'pid', $responseArr])->count();;
    }

    /*
     * 获取我评论过的技术博文
     * */
    public function getCommentArticleList($uid, $offset, $limit)
    {
        $data = TechnologyComment::find()->where(['uid'=> $uid])->offset($offset)->limit($limit)->orderBy('create_time DESC')->asArray()->all();
        if(empty($data)) {
            return $data;
        }
        foreach($data as $key => $value) {
            $data[$key]['tidcopy'] = Technology::find()->where(['id'=> $value['tid']])->asArray()->one();
        }
        return $data;
    }

    /*
     * 获取我评论过的技术博文数量
     * */
    public function getCommentCount($uid)
    {
        return TechnologyComment::find()->where(['uid'=> $uid])->count();
    }

    /*
     * 获取我浏览的技术博文
     * */
    public function getReadArticleList($uid)
    {
        $data = TechnologyExtend::find()->where(['uid'=> $uid, 'isread'=> 1])->select('tid')->orderBy('create_time DESC')->asArray()->all();
        $datas = array_slice($this->array_unique_fb($data), 0, 5);
        foreach($datas as $key => $value) {
            $datas[$key]['tidcopy'] = Technology::find()->where(['id'=> $value['tid']])->asArray()->one();
        }
        return $datas;
    }

    /*
     * 将二维数组去掉重复项，并且保留键名
     * */
    function array_unique_fb($array2D){
        $temArr1 = array();
        $temArr2 = array();
        foreach ($array2D as $k=>$v){
            $v=join(',',$v); //降维,也可以用implode,将一维数组转换为用逗号连接的字符串
            $temArr1[$k]=$v;
        }
        $temp=array_unique($temArr1); //去掉重复的字符串,也就是重复的一维数组
        foreach ($temp as $k => $v){
            $array=explode(',',$v); //再将拆开的数组重新组装
            //下面的索引根据自己的情况进行修改即可
            $temArr2[$k]['tid'] =$array[0];
        }
        return $temArr2;
    }
























}