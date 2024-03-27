<?php

include_once "./core/functions.php";
$username =  getRequest('username','post');
$sex = getRequest('sex','post');
$phone = getRequest('phone','post');
$hometown = getRequest('hometown','post');
$reason = getRequest('reason','post');
$destination = getRequest('destination','post');
$leavetime = getRequest('leavetime','post');
$returntime = getRequest('returntime','post');
$atschool = getRequest('atschool','post');
$asktype = getRequest('asktype','post');
$email = getRequest('email','post');

$data['username'] = $username;
$data['sex'] = $sex;
$data['phone'] = $phone;
$data['hometown'] = $hometown;
$data['reason'] = $reason;
$data['destination'] = $destination;
$data['leavetime'] = $leavetime;
$data['returntime'] = $returntime;
$data['atschool'] = $atschool;
$data['asktype'] = $asktype;
$data['email'] = $email;

foreach ($data as $key=>$value){
    if($value == null){
        echo json_encode(['code'=>500,'msg'=>'提交失败,请检查相关信息是否填写完整']);
        die;
    }
}
$ret =insert($data);
if ($ret){
    echo json_encode(['code'=>200,'msg'=>'提交请假申请成功，请留意邮箱反馈']);
}else{
    echo json_encode(['code'=>500,'msg'=>'服务器错误']);
}
