<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link href="./asset/layui/css/layui.css" rel="stylesheet">
    <script src="./asset/layui/layui.js"></script>
</head>
<body>
<style>
    .demo-login-container{width: 320px; margin: 21px auto 0;}
    .demo-login-other .layui-icon{position: relative; display: inline-block; margin: 0 2px; top: 2px; font-size: 26px;}
</style>

<div style="margin-top:150px">
    <div class="layui-container">
        <div class="layui-row">
            <div class="layui-col-md12">
                <form class="layui-form">
                    <div class="demo-login-container">
                        <div class="layui-form-item">
                            <div class="layui-input-wrap">
                                <div class="layui-input-prefix">
                                    <i class="layui-icon layui-icon-username"></i>
                                </div>
                                <input type="text" name="username" value="" lay-verify="required" placeholder="用户名" lay-reqtext="请填写用户名" autocomplete="off" class="layui-input" lay-affix="clear">
                            </div>
                        </div>
                        <div class="layui-form-item">
                            <div class="layui-input-wrap">
                                <div class="layui-input-prefix">
                                    <i class="layui-icon layui-icon-password"></i>
                                </div>
                                <input type="password" name="password" value="" lay-verify="required" placeholder="密   码" lay-reqtext="请填写密码" autocomplete="off" class="layui-input" lay-affix="eye">
                            </div>
                        </div>
                        <div class="layui-form-item">
                            <input type="checkbox" name="remember" lay-skin="primary" title="记住密码">
                            <a href="form.html#forget" style="float: right; margin-top: 7px;">忘记密码？</a>
                        </div>
                        <div class="layui-form-item">
                            <button class="layui-btn layui-btn-fluid" lay-submit lay-filter="demo-login">登录</button>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
<script>
    layui.use(function(){
        var form = layui.form;
        var layer = layui.layer;
        var $ = layui.jquery;
        // 提交事件
        form.on('submit(demo-login)', function(data){
            var field = data.field; //
            $.post('./controller.php?sign=login', {username:field.username,password:field.password}, function(str){
                if(str.code == 200){
                    layer.msg(str.msg);
                    setTimeout(function() {
                        window.location.href = "index.php";
                    }, 700);
                }
                if(str.code == 500){
                    layer.msg(str.msg);
                }
            },"json");
            return false; // 阻止默认 form 跳转
        });
    });
</script>
</body>
</html>