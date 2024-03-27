<?php
session_start();
$username = $_SESSION['username'];
if(!$username){
    echo '<script>alert("您还没有登录,正在为您跳转~")</script>';
    echo '<a href="./login.php">如果跳转失败，请点击跳转~</a>';
    header("Refresh:1 ;url=login.php");
    die;
}
