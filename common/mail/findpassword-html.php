<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user common\models\User */

$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['site/resetpassword', 'activeToken' =>$user['active_token']]);
?>
<div class="register-box">
    <p>hello <?= Html::encode($user['account']) ?></p>
    <p>感谢您来到amgo官方博客，点击以下链接重置您的密码：</p>
    <p><?= Html::a(Html::encode($resetLink), $resetLink) ?></p>
</div>
