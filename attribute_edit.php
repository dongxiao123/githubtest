<?php
session_start();
require('include/mysql.php');
require('include/function.php');
LYG::checklogin();

if(empty($_REQUEST['id']) || intval($_REQUEST['id'])<1){lyg::showmsg('参数错误');}
$id = intval($_REQUEST['id']);
$info=  $con->find("select * from #__attribute where id=$id");
if(empty($info)){lyg::showmsg('参数错误');}


if(!empty($_POST)){
	//参数校验
	extract($_POST);
	
	if(empty($name) || trim($name)==''){
		LYG::ShowMsg('属性名不能为空');
	}
	$name= trim($name);
	$type= trim($type);
	$tag = trim($tag);

	$ex = $con->rowscount("select count(*) from #__attribute where name='.$name.' and tag='.$tag.' and id<>$id");
	if($ex>0){
		lyg::showmsg("同类属性名已存在");
	}
	
	$eok = $con->update("update #__attribute set name=? where id=$id limit 1",array($name));

	if($eok){
		LYG::ShowMsg('操作成功');
	}else{
		LYG::ShowMsg('操作失败，请重试');
	}
	die();
}
	
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>编辑属性</title>
<link href="style/css.css" rel="stylesheet" type="text/css" />
</head>

<body class="content">

<h5 class='back' onclick='history.go(-1);'><span>返回</span></h5>

<form action='' method='post'>
	<input type='hidden' name='id' value='<?php echo $info['id'];?>'>
	<table cellpadding="3" cellspacing="0" class="table-add">
		<tbody>
			<tr>
				<td align="right" width='100' height='36'>属性名：</td>
				<select name="type" id="type" onchange="changeshow()">
					<option value ="1">性别</option>
					<option value ="2">发型款式</option>
					<option value="3">发型颜色</option>
					<option value="4">发量</option>
					<option value="5">挑染</option>
					<option value="6">修剪</option>
				</select>
				<input type="hidden" name="tag" id="tag" value="<?php echo $info['tag'];?>">
				<td align="left" width='*'>
					<input type='text' class='inp' name='name' value='<?php echo $info['name'];?>'/>
				</td>
			</tr>
			<tr>
				<td align="right" height='50'>　</td>
				<td align="left"><input class='sub' type='submit' value='修改'/></td>
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
	function selectValue(){

		var s = document.getElementById("type");
		var tag =  <?php echo $info['type'];?>;
		var ops = s.options;
		for(var i = 0; i < ops.length; i++){
			var tempValue = ops[i].value;
			if(tempValue == tag)
			{
				ops[i].selected = true;
			}
		}
	}
	window.onload=selectValue;
</script>
</body>
</html>