<?php
session_start();
define("BathPath",getcwd() . '/dawnPHP/');
include('dawnPHP/mylib.php');

/*
1.从session中获取一个u_id，否则提示登陆。
2.如果该u_id是管理员或本文作者，则显示，否则不显示。
*/
$user=null;
if(isset($_SESSION['user'])){
	$user=$_SESSION['user'];
}


//引入视图
include('View/header.php');

if(!isset($_SESSION['user'])){
	include('view/Index/login.html');
}else{
	include('view/Index/index.html');
}

include('View/footer.php');
?>