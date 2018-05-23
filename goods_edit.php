<?php
session_start();
require('include/mysql.php');
require('include/function.php');
LYG::checklogin();


if(empty($_REQUEST['id']) || intval($_REQUEST['id'])<1){lyg::showmsg('参数错误');}
$data_id = intval($_REQUEST['id']);
$info=  $con->find("select * from #__goods where id=$data_id");
if(empty($info)){lyg::showmsg('参数错误');}





if(!empty($_POST)){
	//参数校验
	extract($_POST);

	$class_id = intval($class_id);
	$stock = intval($stock);

	if(empty($goods) || trim($goods)==''){
		LYG::ShowMsg('商品名不能为空');
	}
	$goods= trim($goods);
	
	$ex = $con->rowscount("select count(*) from #__goods where class_id=? and goods=? and id<>?",array(
		$class_id,$goods,$data_id
	));
	if($ex>0){
		lyg::showmsg("同名商品已存在");
	}
	
	$data = array(
		$goods,
		$class_id,
		floatval($price),
		$stock,
		$data_id,
	);
	
	$eok = $con->Update("update #__goods set goods=?,class_id=?,price=?,stock=? where id=? limit 1",$data);

	if($eok){
		LYG::ShowMsg('操作成功');
	}else{
		LYG::ShowMsg('操作失败，请重试');
	}
	
	die();
}

$classinfo = $con->select("select * from #__class");
	
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>编辑商品</title>
<link href="style/css.css" rel="stylesheet" type="text/css" />
</head>

<body class="content">

<h5 class='back' onclick='history.go(-1);'><span>返回</span></h5>

<form action='' method='post'>
	<input type='hidden' name='id' value='<?php echo $data_id;?>'>
	<table cellpadding="3" cellspacing="0" class="table-add">
		<tbody>
			<tr>
				<td align="right" width='100' height='36'>商品名：</td>
				<td align="left" width='*'>
					<input type='text' class='inp' name='goods' value='<?php echo $info['goods'];?>'/>
				</td>
			</tr>
			<tr>
				<td align="right" height='36'>所属分类：</td>
				<td align="left" width='*'>
					<select name="class_id" class="select">
					<?php
					foreach($classinfo as $k=>$v){
						if(intval($v['id'])===intval($info['class_id'])){
							echo "<option value='{$v['id']}' selected='selected'>{$v['classname']}</option>";
						}else{
							echo "<option value='{$v['id']}'>{$v['classname']}</option>";
						}
					}
					?>
					</select>
				</td>
			</tr>
			<tr>
				<td align="right" height='36'>价格：</td>
				<td>
					<input type="text" name="price" class="inp" placeholder="0.00" value="<?php echo floatval($info['price'])?>">
				</td>
			</tr>
			<tr>
				<td align="right" height='36'>库存：</td>
				<td>
					<input type="text" name="stock" class="inp" placeholder="0" value="<?php echo $info['stock']?>">
				</td>
			</tr>
			<tr>
				<td align="right" height='50'>　</td>
				<td align="left"><input class='edit' type='submit' value='修改'/></td>
			</tr>
		</tbody>
	</table>
</form>

</body>
</html>