<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/12/6
 * Time: 12:26
 */

namespace common\models;

use Yii;
use yii\db\ActiveRecord;

class Leave extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%leave}}';
    }

    public function rules()
    {
        return [
            ['content', 'required', 'message'=> '留言内容不得为空'],
            [['name', 'mail', 'uid'], 'safe']
        ];
    }

    public function beforeSave($insert)
    {
        if(parent::beforeSave($insert)) {
            if($this->isNewRecord) {
                $this->create_time = time();
                $this->uid = Yii::$app->session->get(User::USER_ID);
            }
            return true;
        }
    }


}