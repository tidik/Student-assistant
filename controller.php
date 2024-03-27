<?php
include_once "./core/functions.php";
$sign = getRequest('sign');
switch ($sign){
    case 'getAsk':
        $reload =   getRequest('reload');
        if(empty($reload) || $reload == 9){
            $approve =  getRequest('approve');
        }else{
            $approve =  $reload;
        }
        $page = getRequest('page');
        $limit = getRequest('limit');
        $res = getTableData("tk_ask",$approve,$page,$limit);
        $res_cnt = getCount("tk_ask",'approve',$approve)[0]['count(approve)'];
        echo responseDataTable($res_cnt,$res);
        break;
    case 'update':
        $uid = getRequest('UID','post');
        $approve = getRequest('approve','post');
        $ret = updateProve($uid,$approve);
        if($ret){
            if($approve == 2){
                echo json_encode(['code'=>200,'msg'=>'拒绝请假-审批通过']);
                break;
            }
            echo json_encode(['code'=>200,'msg'=>'允许请假-审批通过']);
            break;
        }
        echo json_encode(['code'=>500,'msg'=>'服务器错误']);
        break;
    case 'getToWhereAsk':
        $atschool = getRequest('atschool');
        $page = getRequest('page');
        $limit = getRequest('limit');
        $approve =  getRequest('approve');
        if($atschool || is_null($atschool)){
            $res = getToWhereAsk("tk_ask",1,$page,$limit,$approve);
            $res_cnt = getToWhereCount($atschool)[0]['count(*)'];
        }else{
            $res = getToWhereAsk("tk_ask",0,$page,$limit,$approve);
            $res_cnt = getToWhereCount($atschool)[0]['count(*)'];
        }
        echo responseDataTable($res_cnt,$res);
        break;
    case 'sendmsg':
        $uid = getRequest('UID','post');
        $sendType = getRequest('sendtype','post');
        $notice = getRequest('notice','post');
        if($sendType == "email"){
            $ret = getOneAskRow($uid)[0];
            $username = $ret['username'];
            $email = $ret['email'];
            $approve = $ret['approve'];

            if($notice == 1){
                $res = sendMail($username,$email,$approve,1);
            }else{
                $res = sendMail($username,$email,$approve,0);
            }
            if($res){
                echo json_encode([
                    'code'=>200,
                    'msg'=>'发送邮件通知成功'
                ]);
            }else{
                echo json_encode([
                    'code'=>500,
                    'msg'=>'服务器错误'
                ]);
            }
        }else{
            $ret = [
                'code'=>500,
                'msg'=>'短信通知功能待开发~'
            ];
            echo json_encode($ret);
        }
        break;
    case 'login':
        global $adminConfig;
        $username = getRequest('username','post');
        $password = getRequest('password','post');
        $ret = login($username,$password);
        if($ret){
            echo json_encode([
                'code'=>200,
                'msg'=>'登录成功'
            ]);
        }else{
            echo json_encode([
                'code'=>500,
                'msg'=>'用户名或密码错误'
            ]);
        }
        break;
    case 'logout':
            $ret = logout();
            if($ret){
                echo '<script>alert("您已成功注销正在为您跳转~")</script>';
                echo '<a href="./login.php">如果跳转失败，请点击跳转~</a>';
                header("Refresh:1;url=login.php");
            }
        break;
}
