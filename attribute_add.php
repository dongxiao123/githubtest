<?php
session_start();
require('include/mysql.php');
require('include/function.php');
LYG::checklogin();

if(!empty($_POST)){
	//参数校验
	extract($_POST);
	if(empty($name) || trim($name)==''){
		LYG::ShowMsg('属性名不能为空');
	}
	$name= trim($name);
	$type= trim($type);
	$tag = trim($tag);
	$ex = $con->rowscount("select count(*) from #__attribute where name='.$name.'and tag='.$tag.'");
	if($ex>0){
		lyg::showmsg("同类属性名已存在");
	}
	
	$data = array(
		'name'	=>$name,
		'type'=>$type,
		'tag'=>$tag
	);
	
	$aok = $con->add("attribute",$data);

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
<title>添加门店</title>
<link href="style/css.css" rel="stylesheet" type="text/css" />
</head>

<body class="content">

<h5 class='back' onclick='history.go(-1);'><span>返回</span></h5>

<form action='' method='post'>
	<table cellpadding="3" cellspacing="0" class="table-add">
		<tbody>
			<tr>
				<td align="right" height='36'>所属属性：</td>
				<td align="left" width='*'>
				<select name="type" id="type" onchange="changeshow()" class="select">
					<option value ="1">性别</option>
					<option value ="2">发型款式</option>
					<option value="3">发型颜色</option>
					<option value="4">发量</option>
					<option value="5">挑染</option>
					<option value="6">修剪</option>
					<option value="7">发长</option>
					<option value="8">头旋用量</option>
				</select>
					</td>
				<input type="hidden" name="tag" id="tag" value="性别">
			</tr>
			<tr>
				<td align="right" width='100' height='36'>属性名：</td>
				<td align="left" width='*'>
					<input type='text' class='inp' name='name' placeholder=''/>
				</td>
			</tr>
			<tr>
				<td align="right" height='50'>　</td>
				<td align="left"><input store='sub' type='submit' value='添加'/></td>
			</tr>
		</tbody>
	</table>
</form>
<script type="text/javascript">
      function changeshow(){
		  var obj  = document.getElementById("type");
		  var index = obj.selectedIndex; // 选中索引
		  var text = obj.options[index].text; // 选中文本
		  document.getElementById('tag').value = text;
	}

</script>
</body>
</html>