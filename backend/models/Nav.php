<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/7/11 0011
 * Time: 9:52
 */

namespace backend\models;

use Yii;
use yii\db\ActiveRecord;

class Nav extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%nav}}';
    }

    public function getNav($id=0)
    {
        $rank = Yii::$app->session->get('manager_rank');
        if($id == 0) {
            $obj = self::find()->where(['nid' => 0]) -> asArray() -> all();
        } else {
            $obj = self::find()->where(['nid' => $id]) -> asArray() -> all();
        }
        return $obj ? $obj : '';
    }












}