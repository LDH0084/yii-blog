<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/10/28 0028
 * Time: 14:25
 */

namespace common\models;

use Yii;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

class TechnologyTypes extends ActiveRecord
{
    
    public static function tableName()
    {
        return '{{%technology_types}}';
    }


    //获取技术博文类型列表
    public static function getTechnologyTypesList($post)
    {
        $page = $post['page'];
        $rows = $post['rows'];
        $obj = self::find()
            -> offset($rows * ($page - 1))-> limit($rows)-> asArray()-> all();
        foreach($obj as $key => $value) {
            if($value['pid'] == 0) {
                $obj[$key]['pidcopy'] = '无';
            } else {
                $obj[$key]['pidcopy'] = Self::find()->where(['id'=>$value['pid']])->asArray()->one()['title'];
            }
        }
        return array(
            'total'=>self::find()->count(),
            'rows'=>$obj ? $obj : '',
        );
    }

    //获取一条技术博文类型
    public static function oneTechnologyTypes($id)
    {
        $data = self::find()->where(['id' => $id])->asArray()->one();
        return $data ? $data : '';
    }

    //添加一个技术博文类型
    public static function addTechnologyTypes($post)
    {
        $title = $post['title'];
        $pid = $post['pid'];
        $manager = self::find()->where(['pid'=>$pid,'title'=>$title])->one();
        if($manager) {
            return -1;
        }
        $sql = "INSERT INTO {{%technology_types}} (title, pid) VALUES ('$title', '$pid')";
        if(Yii::$app->db->createCommand($sql)->execute()) {
            return true;
        }
    }

    //修改技术博文类型资料
    public static function editTechnologyTypes($post)
    {
        $id = $post['id'];
        $title = $post['title'];
        $pid = $post['pid'];
        $manager = self::find()->where(['pid'=>$pid,'title'=>$title])->andWhere(['!=','id',$id])->one();
        if($manager) {
            return -1;
        }
        $sql = "UPDATE {{%technology_types}} SET title='$title',pid='$pid' WHERE id='$id'";
        if(Yii::$app->db->createCommand($sql)->execute()) {
            return true;
        }
    }

    //删除一条或多条技术博文类型
    public static function deleteTechnologyTypes($post)
    {
        $sql = "DELETE FROM {{%technology_types}} WHERE id IN ($post)";
        if(Yii::$app->db->createCommand($sql)->execute()) {
            return 1;
        } else {
            return -1;
        }
    }
    
    /*
     * dropdown标签页面获取分类
     * */
    public static function getSelectTechnologyTypes()
    {
        $data = self::find()->where(['!=', 'pid',0])->asArray()->all();
        //ArrayHelper::map函数表示将数组改变成用第二个参数做下表，第三个参数为值的新数组
        return ArrayHelper::map($data, 'id', 'title');
    }
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
}