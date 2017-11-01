<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/11/28
 * Time: 21:23
 */

namespace common\models;

use yii;
use yii\db\ActiveRecord;

class Link extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%link}}';
    }

    public function rules()
    {
        return [
            [['title', 'describe', 'webmaster', 'mail', 'status', 'link', 'sort_order'], 'safe']
        ];
    }

    //获取直通车列表
    public static function getLinkList($post)
    {
        $page = $post['page'];
        $rows = $post['rows'];
        $sort = $post['sort'];
        $order = $post['order'];
        $map = array();
        $map2 = array();
        $map3 = array();
        $obj = self::find()
            -> andFilterWhere($map) ->andFilterWhere($map2) ->andFilterWhere($map3)
            -> select('id,title,webmaster,describe,mail,link,status,sort_order')-> orderBy('sort_order '.$order)
            -> offset($rows * ($page - 1))-> limit($rows)-> asArray()-> all();
        foreach ($obj as $key=>$value) {
            $obj[$key]['statuscopy'] = $value['status'] == '1' ? '显示' : ($value['status'] == '-1' ? '拒绝' : '未处理');
        }
        //echo $this->getLastSql();
        return array(
            'total'=>self::find()->where($map)->count(),
            'rows'=>$obj ? $obj : '',
        );
    }

    //删除一条或多条直通车
    public static function deleteLink($post)
    {
        $sql = "DELETE FROM {{%link}} WHERE id IN ($post)";
        if(Yii::$app->db->createCommand($sql)->execute()) {
            return 1;
        } else {
            return -1;
        }
    }






























}