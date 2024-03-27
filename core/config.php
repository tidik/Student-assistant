<?php

final class Config{
    const DBHOST="localhost";
    const DBUSER="dev_inik_cc";
    const DBNAME="dev_inik_cc";
    const DBPWD="hWGL8pFyBP3jZf4R";
}

$STMPConfig = [
    'HOST' => 'smtp.qq.com',
    'UserName' => 'xxx@qq.com', //QQ邮箱
    'Password' => '', //授权码非QQ登录密码
    'Port' => '465',
    'CharSet' => 'UTF-8',
    'SMTPSecure' => 'ssl',
    'SMTPAuth' => 'true'
];

$adminConfig =[
    'username' =>'admin',
    'password'=>'e10adc3949ba59abbe56e057f20f883e' //123456 32位小写MD5
];

