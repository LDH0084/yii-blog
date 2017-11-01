<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/8/2 0002
 * Time: 11:15
 */

namespace common\models;

use Yii;
use yii\db\ActiveRecord;

class Video extends ActiveRecord
{

    public static function tableName()
    {
        return '{{%video}}';
    }

    public function rules()
    {
        return [
            [['title','describe','types','dlaccount','dlpassword','group','private','thumbnail'], 'required', 'message'=> '内容不得为空'],
            ['title', 'string', 'min' => 2, 'max' => 50, 'tooShort' => '标题不得少于2个字符', 'tooLong' => '标题不得大于50位字符', 'skipOnEmpty' => false],
            ['describe' , 'string' ,'min' =>10, 'tooShort' => '内容长度不得小于100个字符'],
            [['types', 'status'], 'integer'],
        ];
    }

    public function beforeSave($insert)
    {
        if(parent::beforeSave($insert)) {
            $this->create_time = time();
            return true;
        }
        return false;
    }


    //获取用户列表
    public static function getVideoList($post)
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
            -> select('id,title,describe,types,status,create_time,dlpassword,dlaccount,group')-> orderBy('create_time '.$order)
            -> offset($rows * ($page - 1))-> limit($rows)-> asArray()-> all();
        foreach ($obj as $key=>$value) {
            $obj[$key]['create_time'] = date('Y-m-d H:i:s', $value['create_time']);
            $obj[$key]['status'] = $value['status'] == '1' ? '显示' : '下架';
            $obj[$key]['typescopy'] = VideoTypes::find()->where(['id'=> $value['types']])->asArray()->one()['title'];
        }
        //echo $this->getLastSql();
        return array(
            'total'=>self::find()->where($map)->count(),
            'rows'=>$obj ? $obj : '',
        );
    }


    //删除一条或多条技术博文
    public static function deleteVideo($post)
    {
        $sql = "DELETE FROM {{%video}} WHERE id IN ($post)";
        if(Yii::$app->db->createCommand($sql)->execute()) {
            return 1;
        } else {
            return -1;
        }
    }






}