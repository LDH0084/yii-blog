<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/11/19
 * Time: 17:20
 */

namespace common\models;

use Yii;
use yii\db\ActiveRecord;

class Advice extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%advice}}';
    }

    public function rules()
    {
        return [
            [['name', 'mail', 'content'], 'required', 'message'=> '请填写内容'],
            ['mail', 'email', 'message'=> '请填写正确的邮箱'],
            ['content', 'string', 'min'=> 10, 'tooShort'=> '反馈的内容至少要10个字符'],
            ['contact', 'safe']
        ];
    }

    public function beforeSave($insert)
    {
        if(parent::beforeSave($insert)) {
            if($this->isNewRecord) {
                $this->create_time = time();
            }
            return true;
        }
    }

    //获取反馈列表
    public static function getAdviceList($post)
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
        if ($account) {
            $map = array('like', 'account', $account);
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
            -> select('id,name,mail,create_time,status,contact,content')-> orderBy('create_time '.$order)
            -> offset($rows * ($page - 1))-> limit($rows)-> asArray()-> all();
        foreach ($obj as $key=>$value) {
            $obj[$key]['create_time'] = date('Y-m-d H:i:s', $value['create_time']);
            $obj[$key]['statuscopy'] = $value['status'] == '1' ? '未回复' : '已回复';
        }
        //echo $this->getLastSql();
        return array(
            'total'=>self::find()->where($map)->count(),
            'rows'=>$obj ? $obj : '',
        );
    }

    //已回复反馈设置
    public static function responseAdvice($post)
    {
        $sql = "UPDATE {{%advice}} SET status = -1 WHERE id IN ($post)";
        if(Yii::$app->db->createCommand($sql)->execute()) {
            return 1;
        } else {
            return -1;
        }
    }

    //删除一条或多条反馈
    public static function deleteAdvice($post)
    {
        $sql = "DELETE FROM {{%advice}} WHERE id IN ($post)";
        if(Yii::$app->db->createCommand($sql)->execute()) {
            return 1;
        } else {
            return -1;
        }
    }






















}