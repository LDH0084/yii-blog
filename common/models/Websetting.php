<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/11/19
 * Time: 11:37
 */

namespace common\models;


use yii\db\ActiveRecord;

class Websetting extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%websetting}}';
    }

    public function rules()
    {
        return [
            [['title','keyword','description','copyright','author','generator'], 'required', 'message'=> '内容不得为空']
        ];
    }








}