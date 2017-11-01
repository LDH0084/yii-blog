<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/10/28 0028
 * Time: 15:09
 */

namespace frontend\components;


use common\models\TechnologyTypes;

class TechnologytypesQry extends BaseQry
{

    /*
     * 获取全部分类
     * */
    public function getAllTypesList()
    {
        $data = TechnologyTypes::find()->where(['pid'=>0])->asArray()->all();
        foreach($data as $key => $value) {
            $data[$key]['child'] = TechnologyTypes::find()->where(['pid'=>$value['id']])->asArray()->all();
        }
        return $data;
    }

























}