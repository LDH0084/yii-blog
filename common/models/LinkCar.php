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

class LinkCar extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%link_car}}';
    }

    public function rules()
    {
        return [
            [['title', 'thumbnail', 'status', 'link', 'sort_order'], 'safe']
        ];
    }

    //获取直通车列表
    public static function getLinkCarList($post)
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
            -> select('id,title,thumbnail,link,status,sort_order')-> orderBy('sort_order '.$order)
            -> offset($rows * ($page - 1))-> limit($rows)-> asArray()-> all();
        foreach ($obj as $key=>$value) {
            $obj[$key]['statuscopy'] = $value['status'] == '1' ? '显示' : '隐藏';
        }
        //echo $this->getLastSql();
        return array(
            'total'=>self::find()->where($map)->count(),
            'rows'=>$obj ? $obj : '',
        );
    }

    //删除一条或多条直通车
    public static function deleteLinkCar($post)
    {
        $sql = "DELETE FROM {{%link_car}} WHERE id IN ($post)";
        if(Yii::$app->db->createCommand($sql)->execute()) {
            return 1;
        } else {
            return -1;
        }
    }






























}