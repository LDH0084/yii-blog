<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/10/31 0031
 * Time: 16:50
 */

namespace common\models;

use Yii;
use yii\db\ActiveRecord;

class VideoComment extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%video_comment}}';
    }

    //获取评论列表
    public static function getVideoCommentList($post)
    {
        $page = $post['page'];
        $rows = $post['rows'];
        $sort = $post['sort'];
        $order = $post['order'];
        $account = isset($post['account']) ? $post['account'] : '';
        $date_from = isset($post['date_from']) ? $post['date_from'] : '';
        $date_to = isset($post['date_to']) ? $post['date_to'] : '';
        $map = array();
        $map2 = array();
        $map3 = array();
        if (!empty($account)) {
            $map = array('like', 'title', $account);
        }
        if ($date_from && $date_to) {
            $map2 = array('>=', 'create_time', strtotime($date_from));
            $map3 = array('<=', 'create_time', strtotime($date_to) + 24*60*60);
        } else if ($date_from) {
            $map2 = array('>=', 'create_time', strtotime($date_from));
        } else if ($date_to) {
            $map2 = array('<=', 'create_time', strtotime($date_to) + 24*60*60);
        }
        $obj = self::find()
            -> andFilterWhere($map) ->andFilterWhere($map2) ->andFilterWhere($map3)
            -> select('id,tid,pid,uid,content,status,create_time')-> orderBy('create_time '.$order)
            -> offset($rows * ($page - 1))-> limit($rows)-> asArray()-> all();
        foreach ($obj as $key=>$value) {
            $obj[$key]['create_time'] = date('Y-m-d H:i:s', $value['create_time']);
            $obj[$key]['status'] = $value['status'] == '1' ? '显示' : '下架';
            $obj[$key]['tidcopy'] = Technology::find()->where(['id'=> $value['tid']])->asArray()->one()['title'];
            $obj[$key]['pidcopy'] = $value['pid'] != '0' ? '二级评论' : '一级评论';
            $obj[$key]['uidcopy'] = User::find()->where(['id'=> $value['uid']])->asArray()->one()['account'];
            $obj[$key]['childnum'] = TechnologyComment::find()->where(['pid'=> $value['id']])->count();
        }
        //echo $this->getLastSql();
        return array(
            'total'=>self::find()->where($map)->count(),
            'rows'=>$obj ? $obj : '',
        );
    }


    //删除一条或多条评论
    public static function deleteVideoComment($post)
    {
        $sql = "DELETE FROM {{%video_comment}} WHERE id IN ($post)";
        if(Yii::$app->db->createCommand($sql)->execute()) {
            return 1;
        } else {
            return -1;
        }
    }
































}