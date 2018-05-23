<?php
session_start();
require('include/mysql.php');
require('include/function.php');
LYG::checklogin();
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>管理后台</title>
</head>


<frameset rows="45,*" frameborder="0">
	<frame src="head.php" style="border-bottom:0px solid #ccc;"/>
	<frameset cols="120,*">
    	<frame src="left.php" style="border-right:1px solid #ccc"/>
        <frame name="right" src="default.php"/>
    </frameset>
</frameset><noframes></noframes>


</html>
