<?php
session_start();
require('include/mysql.php');
require('include/function.php');
LYG::checklogin();

if(!empty($_POST)){
	//参数校验
	extract($_POST);
	if(empty($classname) || trim($classname)==''){
		LYG::ShowMsg('分类名不能为空');
	}
	$classname= trim($classname);
	
	$ex = $con->rowscount("select count(*) from #__class where classname=?",array($classname));
	if($ex>0){
		lyg::showmsg("同名分类已存在");
	}
	
	$data = array(
		'classname'	=>$classname
	);
	
	$aok = $con->add("class",$data);

	if($aok){
		LYG::ShowMsg('添加成功');
	}else{
		LYG::ShowMsg('添加失败，请重试');
	}
	
	die();
}
	
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>添加分类</title>
<link href="style/css.css" rel="stylesheet" type="text/css" />
</head>

<body class="content">

<h5 class='back' onclick='history.go(-1);'><span>返回</span></h5>

<form action='' method='post'>
	<table cellpadding="3" cellspacing="0" class="table-add">
		<tbody>
			<tr>
				<td align="right" width='100' height='36'>分类名：</td>
				<td align="left" width='*'>
					<input type='text' class='inp' name='classname' placeholder=''/>
				</td>
			</tr>
			<tr>
				<td align="right" height='50'>　</td>
				<td align="left"><input class='sub' type='submit' value='添加'/></td>
			</tr>
		</tbody>
	</table>
</form>

</body>
</html>