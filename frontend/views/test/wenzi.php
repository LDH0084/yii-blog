<?php
header('content-type:text/html;charset=utf-8;');
//������Ŀ��ļ�
include "phpqrcode/phpqrcode.php";
QRcode::png('http://www.smister.com');
//ʾ���������ص�ַ��http://pan.baidu.com/s/1kTyruRl
exit();