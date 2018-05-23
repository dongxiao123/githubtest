<?php
session_start();
require('include/mysql.php');
require('include/function.php');
LYG::checklogin();

if(empty($_REQUEST['id']) || intval($_REQUEST['id'])<1){lyg::showmsg('参数错误');}
$dataid = intval($_REQUEST['id']);
$info=  $con->find("select * from #__order where id=$dataid");
if(empty($info)){lyg::showmsg('参数错误');}

if(!empty($_POST)){
	//参数校验
	extract($_POST);
	if($kehu==''){
		LYG::ShowMsg('客户不能为空');
	}
	if($dianhua==''){
		LYG::ShowMsg('电话不能为空');
	}
	$shangpin_id = intval($shangpin_id);
	$shuliang = intval($shuliang);

	if($dizhi==''){
		LYG::ShowMsg('地址不能为空');
	}
	$status = intval($status)%3;
	$isshow = intval($isshow)%2;
	
	if($isshow===1 && $nickname==''){
		LYG::ShowMsg('设置了展示信息，但展示昵称为空');
	}
		
	$result	= $con->Update("update #__order set kehu=? ,dianhua=?,shangpin_id=?,shuliang=?,dizhi=?,liuyan=?,jindu=?,status=?,isshow=?,nickname=? where id=? limit 1",
	array($kehu,$dianhua,$shangpin_id,$shuliang,$dizhi,$liuyan,$jindu,$status,$isshow,$nickname,$dataid));
	if($result){
		LYG::ShowMsg('修改成功');
	}else{
		LYG::ShowMsg('订单没有更改');
	}
	
	die();
	
}

//所有分类信息
$classinfo  = $con->select("select * from #__class");

//当前订单分类下所有商品
$goodsinfo = $con->select("select * from #__goods where class_id=?",array($info['fenlei_id']));

//订单所有状态
$_status = array(
    '0' =>array('未处理',"未处理"),
    '1' =>array('处理中',"<span style='color:blue'>处理中</span>"),
    '2' =>array('完成',"<span style='color:#228810'>完成</span>"),
);

//订单是否前台展示
$_isshow = array(
    '0' =>array('否',"否"),
    '1' =>array('是',"<span style='color:blue'>是</span>"),
);

	
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>修改订单</title>
<link href="style/css.css" rel="stylesheet" type="text/css" />
<style type="text/css">
label{margin-right:10px;}
</style>
</head>


<body class="content">

<h5 class='back' onclick='history.go(-1);'><span>返回</span></h5>

<form action='' method='post'>
<input type='hidden' name='id' value="<?php echo $dataid;?>" />
<table cellpadding="3" cellspacing="0" class="table-add">

    <tbody>
    	<tr>
        	<td align="right" width='100' height='36'>客户：</td>
            <td align="left" width='*'>
				<input class="inp" type="text" name="kehu" value="<?php echo $info['kehu'];?>">
			</td>
        </tr>
		<tr>
        	<td align="right" height='36'>电话：</td>
            <td align="left">
				<input class='inp' type='text' name='dianhua' value="<?php echo $info['dianhua'];?>" />
			</td>
        </tr>
        <tr>
        	<td align="right" height='36'>商品分类：</td>
            <td align="left">
            	<select class="select" disabled="disabled">
            	<?php
            	foreach ($classinfo as $k => $v) {
            		if(intval($info['fenlei_id'])===intval($v['id'])){
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
        	<td align="right" height='36'>商品：</td>
            <td align="left">
            	<select name="shangpin_id" class="select">
            	<?php
            	foreach ($goodsinfo as $k => $v) {
            		if(intval($info['shangpin_id'])===intval($v['id'])){
            			echo "<option value='{$v['id']}' selected='selected'>{$v['goods']}</option>";
            		}else{
            			echo "<option value='{$v['id']}'>{$v['goods']}</option>";
            		}
            	}
            	?>
            	</select>
            </td>
        </tr>
		<tr>
        	<td align="right" height='36'>数量：</td>
            <td align="left">
            	<input class='inp' type='text' name='shuliang' value="<?php echo $info['shuliang'];?>" />
            </td>
        </tr>
		<tr>
        	<td align="right" height='36'>地址：</td>
            <td align="left">
            	<input class='inp' type='text' name='dizhi' value="<?php echo $info['dizhi'];?>" />
            </td>
        </tr>
		<tr>
        	<td align="right" height='36'>添加时间：</td>
            <td align="left">
            	<?php echo $info['addtime']==0?'无': date('Y-m-d H:i:s',$info['addtime']);?>
            </td>
        </tr>
		<tr>
        	<td align="right" height='36'>客户IP：</td>
            <td align="left">
            	<?php echo $info['ip'];?>
            </td>
        </tr>
		<tr>
        	<td align="right" height='36'>来路：</td>
            <td align="left"><?php 
			if($info['referer']!=''){
				echo '<a style="color:#ED8A6D" href="'.$info['referer'].'" target="_blank">'.$info['referer'].'</a>';
			}else{
				echo '未知';
			}?></td>
        </tr>
		<tr>
			<td align="right" height='36'>状态：</td>
            <td align="left">
            	<?php
            	foreach($_status as $k=>$v){
            		if(intval($info['status'])===intval($k)){
            			echo "<input type='radio' name='status' id='status{$k}' value='{$k}' checked='checked'><label for='status{$k}'>{$v[1]}</label>";
            		}else{
            			echo "<input type='radio' name='status' id='status{$k}' value='{$k}'><label for='status{$k}'>{$v[1]}</label>";
            		}
            	}
            	?>
			</td>
		</tr>
		<tr>
        	<td align="right" height='36'>买家留言：</td>
            <td align="left">
            	<textarea name='liuyan'><?php echo $info['liuyan'];?></textarea>
            </td>
        </tr>
		<tr>
        	<td align="right" height='36'>进度：</td>
            <td align="left">
            	<textarea name='jindu' placeholder='如：客户要求走顺丰快递。'><?php echo $info['jindu'];?></textarea>
            </td>
        </tr>
		<tr>
			<td align="right" height='36'>是否展示：</td>
            <td align="left">
				<?php
            	foreach($_isshow as $k=>$v){
            		if(intval($info['isshow'])===intval($k)){
            			echo "<input type='radio' checked='checked' name='isshow' id='isshow{$k}' value='{$k}'><label for='isshow{$k}'>{$v[1]}</label>";
            		}else{
            			echo "<input type='radio' name='isshow' id='isshow{$k}' value='{$k}'><label for='isshow{$k}'>{$v[1]}</label>";
            		}
            	}
            	?>
			</td>
		</tr>
		<tr>
        	<td align="right" height='36'>展示姓名：</td>
			<td align="left">
				<input class='inp' type='text' placeholder='前台展示姓名' name='nickname' value="<?php echo $info['nickname'];?>" />
			</td>
        </tr>
		<tr>
        	<td align="right" height='50'>　</td>
            <td align="left">
            	<input class='sub' type='submit' value='修改'/>　<input class='reset' type='reset' value='重置'></td>
        </tr>
    </tbody>

    
</table>
</form>

</body>
</html>