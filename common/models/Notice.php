<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/11/28
 * Time: 21:00
 */

namespace common\models;


use yii\db\ActiveRecord;

class Notice extends ActiveRecord
{

    public static function tableName()
    {
        return '{{%notice}}';
    }

    public function rules()
    {
        return [
            [['contentone','contenttwo','status'], 'safe']
        ];
    }

    public function beforeSave($insert)
    {
        if(parent::beforeSave($insert)) {
            $this->create_time = time();
            return true;
        }
    }


}