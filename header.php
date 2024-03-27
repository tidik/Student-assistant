<?php include_once "./common.php"; ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>电子假条系统</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="./asset/layui/css/layui.css" rel="stylesheet">
    <script src="./asset/layui/layui.js"></script>
</head>
<body>
<div class="layui-layout layui-layout-admin">
    <div class="layui-header">
        <div class="layui-logo layui-hide-xs layui-bg-black"><a href="./index.php" style="color: white">电子假条审批系统</a></div>
        <ul class="layui-nav layui-layout-right">
            <li class="layui-nav-item layui-hide layui-show-sm-inline-block">
                <a href="javascript:;">
                    <img src="https://unpkg.com/outeres@0.0.10/img/layui/icon-v2.png" class="layui-nav-img">
                    <?php echo $_SESSION['username'];?>
                </a>
                <dl class="layui-nav-child">
                    <dd><a href="./controller.php?sign=logout">注销</a></dd>
                </dl>
            </li>
        </ul>
    </div>