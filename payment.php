<?php
session_start();
require('include/mysql.php');
require('include/function.php');
LYG::checklogin();


?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>付款方式</title>
<link href="style/css.css" rel="stylesheet" type="text/css" />
</head>

<body class="content">

<table cellpadding="3" cellspacing="0">
	<thead>
    	<tr>
            <th width="100">#</th>
            <th width="*">名称</th>
            <th width="100">状态</th>
            <th width="100">-</th>
        </tr>
    </thead>
    <tbody>
    	<tr class='list'>
        	<td align="center">1</td>
        	<td align="center">货到付款</td>
        	<td align="center" style="color:green">已开启</td>
            <td align="center">
				<a class="edit" href="">配置</a>
			</td>
        </tr>
		<tr class='list' style='color:#ccc'>
        	<td align="center">2</td>
        	<td align="center">微信支付</td>
        	<td align="center">未开启</td>
            <td align="center">
				<a class="edit" onclick="alert('该项属新增付款方式，请联系技术开启');" target="_blank" href="http://wpa.qq.com/msgrd?v=3&uin=10287093&site=qq&menu=yes">配置</a>
			</td>
        </tr>
		<tr class='list' style='color:#ccc'>
        	<td align="center">3</td>
        	<td align="center">支付宝付款</td>
        	<td align="center">未开启</td>
            <td align="center">
				<a class="edit" onclick="alert('该项属新增付款方式，请联系技术开启');" target="_blank" href="http://wpa.qq.com/msgrd?v=3&uin=10287093&site=qq&menu=yes">配置</a>
			</td>
        </tr>
		<tr class='list' style='color:#ccc'>
        	<td align="center">4</td>
        	<td align="center">银联在线</td>
        	<td align="center">未开启</td>
            <td align="center">
				<a class="edit" onclick="alert('该项属新增付款方式，请联系技术开启');" target="_blank" href="http://wpa.qq.com/msgrd?v=3&uin=10287093&site=qq&menu=yes">配置</a>
			</td>
        </tr>
    </tbody>    
</table>

<p>七歌工作室技术在线QQ：10287093，邮箱：10287093@qq.com</p>

</body>
</html>