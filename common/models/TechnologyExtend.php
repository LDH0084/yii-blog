<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/11/1 0001
 * Time: 11:02
 */

namespace common\models;


use yii\db\ActiveRecord;

class TechnologyExtend extends ActiveRecord
{

    public static function tableName()
    {
        return '{{%technology_extend}}';
    }


}