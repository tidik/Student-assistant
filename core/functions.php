<?php
include_once "./core/DB.php";
include_once "./core/class.phpmailer.php";
include_once "./core/class.smtp.php";
$db = new DB();


function insert($data){
    global $db;
    $sql = "INSERT INTO `dev_inik_cc`.`tk_ask` ( `UID`,`username`, `sex`, `phone`, `hometown`, `reason`, `destination`, `leavetime`, `returntime`, `totalask`, `approve`, `atschool`,  `asktype`, `email`) VALUES (NULL, '{$data['username']}',  '{$data['sex']}',  '{$data['phone']}', '{$data['hometown']}',  '{$data['reason']}', ' {$data['destination']}',  '{$data['leavetime']}', ' {$data['returntime']}', '1', '0',  '{$data['atschool']}','{$data['asktype']}', ' {$data['email']}')";
    $db->setSql($sql);
    return $db->dbExec();
    //return $db->getSql();
}
function logout(){
    session_start();
    unset($_SESSION['username']);
    return true;
}
function login($username,$password){
    global $adminConfig;
    if((trim($username) == $adminConfig['username'])&&(md5(trim($password))==$adminConfig['password'])){
        session_start();
        $_SESSION['username'] = $username;
        return true;
    }
    return false;
}
function getTableData($table,$approve,$page = 1,$limit = 10){
    global $db;
    $sql = "select * from `{$table}` where approve={$approve}  limit ".($page-1)*$limit.",{$limit} ";
    $db->setSql($sql);
    return $db->getData();
}
function getCount($table,$field,$where){
    global $db;
    $sql = "select count({$field}) from `{$table}` where {$field} = {$where}";
    $db->setSql($sql);
    return $db->getData();
}
function getToWhereAsk($table,$atschool,$page = 1,$limit = 10,$approve){
    global $db;
    $sql = "select * from `{$table}` where atschool={$atschool} and approve={$approve}  limit ".($page-1)*$limit.",{$limit} ";
    $db->setSql($sql);
    return $db->getData();
}
function getToWhereCount($atschool){
    global $db;
    $sql = "select count(*) from `tk_ask` where approve=1 and atschool=".$atschool;
    $db->setSql($sql);
    return $db->getData();
}
function responseDataTable($count,$data){
    $json = [
        "code"=>0,
        "count"=>$count,
        "data"=>$data
    ];
   return json_encode($json);
}
function getRequest($name,$type = 'get'){
    switch($type){
        case 'get':
            return isset($_GET[$name])?trim($_GET[$name]):null;
        case 'post':
            return isset($_POST[$name])?trim($_POST[$name]):null;
        default:
            return isset($_REQUEST[$name])?trim($_REQUEST[$name]):null;
    }
}

function updateProve($uid,$approve){
    global $db;
    $sql = "update `tk_ask` set approve={$approve} where UID={$uid}";
    $db->setSql($sql);
    return $db->dbExec();
}

function getOneAskRow($uid)
{
    global $db;
    $sql = "select * from `tk_ask` where UID={$uid}";
    $db->setSql($sql);
    return $db->getData();
}

/******邮件发送部分*************/
//初始化邮件助手
function sendMail($name,$tomail,$approve,$notice){
    global $STMPConfig;
    $mail = InitialPHPMaile($STMPConfig);
    $mail->setFrom($STMPConfig['UserName'], 'EAskSys');  //发件人
    $mail->addAddress($tomail, $name);  // 收件人
    $mail->addReplyTo($STMPConfig['UserName'], 'EAskSys'); //回复的时候回复给哪个邮箱 建议和发件人一致
    $mail->isHTML(true);
    if($notice == 1){
        $mail->Subject = '通知-电子假条系统';
        $mail->Body    = emailTpl(3,$name);
    }else{
        $mail->Subject = ' 关于'.$name.'的请假审批反馈-电子假条系统';
        $mail->Body    = emailTpl($approve,$name);
        if($approve == 1){
            $txt= "请假审批状态：已准假";
        }else if($approve == 2){
            $txt= "请假审批状态：未准假";
        }
        $mail->AltBody = $txt;
    }
    return $mail->send();
}


function InitialPHPMaile($STMPConfig = array())
{
    $postMaile = new PHPMailer(true);
    $postMaile->CharSet = $STMPConfig['CharSet'];
    $postMaile->SMTPDebug = 0;                        // 调试模式输出
    $postMaile->isSMTP();                             // 使用SMTP
    $postMaile->Host = $STMPConfig['HOST'];                // SMTP服务器
    $postMaile->SMTPAuth = $STMPConfig['SMTPAuth'];                      // 允许 SMTP 认证
    $postMaile->Username = $STMPConfig['UserName'];                // SMTP 用户名  即邮箱的用户名
    $postMaile->Password = $STMPConfig['Password'];             // SMTP 密码  部分邮箱是授权码(例如163邮箱)
    $postMaile->SMTPSecure = $STMPConfig['SMTPSecure'];                    // 允许 TLS 或者ssl协议
    $postMaile->Port = $STMPConfig['Port'];
    return $postMaile;
}

/**
 * @param $approve
 * @param $username
 * @return string+
 * 邮件发送模板
 */
function emailTpl($approve,$username){
    if($approve == 1){
        $tip = '审批状态:';
        $title = '关于'.$username.'的请假审批反馈-电子假条系统';
        $msg = '<span style="color:green;">已准假</span>';
    }
    if($approve == 2){
        $tip = '审批状态:';
        $title = '关于'.$username.'的请假审批反馈-电子假条系统';
        $msg = '<span style="color:red;">未准假</span>';
    }
    if($approve == 3){
        $tip = '紧急通知:';
        $title = '紧急通知-电子假条系统';
        $msg = '<span style="color:orange;">请于半小时内主动与老师取得联系</span>';
    }
    $tpl='<div class="emailpaged" style="background-image: url(https://inik.cc/email.jpg);-webkit-background-size: cover;-moz-background-size: cover;-o-background-size: cover;background-size: cover;background-position: center center;background-repeat: no-repeat;">
        <div class="emailcontent" style="width:100%;max-width:720px;text-align: left;margin: 0 auto;padding-top: 80px;padding-bottom: 20px">
            <div class="emailtitle">
                <h1 style="color:#fff;background: #51a0e3;line-height:70px;font-size:24px;font-weight:normal;padding-left:40px;margin:0">
                 '.$title.'
                </h1>
                <div class="emailtext" style="background:#fff;padding:20px 32px 40px;">
            
            <table cellpadding="0" cellspacing="0" border="0" style="width:100%;border-top:1px solid #eee;border-left:1px solid #eee;color:#6e6e6e;font-size:16px;font-weight:normal">
                <thead><tr><th colspan="2" style="padding:10px 0;border-right:1px solid #eee;border-bottom:1px solid #eee;text-align:center;background:#f8f8f8;">邮件内容如下</th></tr></thead>
                <tbody>
                    <tr>
                        <td style="padding:10px 0;border-right:1px solid #eee;border-bottom:1px solid #eee;text-align:center;width:100px">'.$tip.'</td>
                        <td style="padding:10px 20px 10px 30px;border-right:1px solid #eee;border-bottom:1px solid #eee;line-height:30px">'.$msg.'</td>
                    </tr>
                    <tr>
                        <td style="padding:10px 0;border-right:1px solid #eee;border-bottom:1px solid #eee;text-align:center;width:100px;color:red">温馨提示:</td>
                        <td style="padding:10px 20px 10px 30px;border-right:1px solid #eee;border-bottom:1px solid #eee;line-height:30px">如有其他问题，请及时与老师沟通。</td>
                    </tr>
                    <tr>
                        <td style="padding:10px 0;border-right:1px solid #eee;border-bottom:1px solid #eee;text-align:center;">发送时间</td>
                        <td style="padding:10px 20px 10px 30px;border-right:1px solid #eee;border-bottom:1px solid #eee;line-height:30px"><span style="border-bottom: 1px dashed rgb(204, 204, 204); position: relative;">'.date("Y-m-d H:i:s").'</span></td>
                    </tr>               
                </tbody>
            </table>

                <p style="color: #6e6e6e;font-size:13px;line-height:24px;">(此邮件由系统自动发出, 请勿回复。)</p>
                </div>
                <div class="emailad" style="margin-top: 24px;text-align:center;">
                </div>
                <p style="color: #6e6e6e;font-size:13px;line-height:24px;text-align:right;padding:0 32px">邮件来自：<a href="https://tidik.cn/" style="color:#51a0e3;text-decoration:none" target="_blank">EaskSys</a></p>
            </div>
        </div>
    </div>';
    return $tpl;
}