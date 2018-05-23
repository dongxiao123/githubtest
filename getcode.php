<?php
//获取调用代码
session_start();
require('include/mysql.php');
require('include/function.php');
LYG::checklogin();

if(!empty($_POST)){
	//参数校验
	extract($_POST);

	$class_id = intval($class_id);

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
		$data_id,
	);
	
	$eok = $con->Update("update #__goods set goods=?,class_id=?,price=? where id=? limit 1",$data);

	if($eok){
		LYG::ShowMsg('操作成功');
	}else{
		LYG::ShowMsg('操作失败，请重试');
	}
	
	die();
}

$classinfo = $con->select("select * from #__class");

//url
$http_type = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https')) ? 'https://' : 'http://';

$url = $http_type . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
$url = substr($url,0,strripos($url,"/"));

//所有主题
$themes = array();
$rootpath = dirname(__FILE__).'/themes';
$dp = dir($rootpath);
while($file=$dp->read()){
	if($file!='.'&& $file!='..'){
		if(is_dir($rootpath."/".$file) && strlen($file)>7){
			$n = substr($file,7);
			$themes[]=$n;
		}
	}
}
$dp->close();	
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>获取调用代码</title>
<link href="style/css.css" rel="stylesheet" type="text/css" />
<style type="text/css">
button{display:inline-block; background:black;color:#fff;border:0;font-size:14px; line-height:1em;padding:8px 20px;}
select.select{width:100%;box-sizing:border-box}
input.inp{width:100%; box-sizing:border-box}
textarea{font-size:16px;padding:5px;box-sizing:border-box;color:green}
</style>
</head>
<script type="text/javascript">
function _create(){
	var t = document.getElementById('themes').value;
	var c = document.getElementById('class').value;
	var w = document.getElementById('width').value;
	var h = document.getElementById('height').value;
	var url = "<?php echo $url;?>";
	url+="/themes/?t="+t+"&c="+c+"&w="+w+"&h="+h;
	var html ='<script type="text/javascript" src="'+url+'"><\/script>';
	document.getElementById('code').value = html;
	
	setIframeHtml(url);
}
function setIframeHtml(url){
	document.getElementById('iframe').src="getcode_view.php?url="+encodeURIComponent(url);
}
</script>

<body class="content">

<table cellpadding="3" cellspacing="0" class="table-add">
	<tbody>
		<tr>
			<td align="right" width='60' height='36'>风格：</td>
			<td align="left" width='120'>
				<select id="themes" class="select">
				<?php 
				foreach($themes as $o){
					echo "<option value='{$o}'>{$o}</option>";
				}?>
				</select>
			</td>
			<td align="right" width='60' height='36'>分类：</td>
			<td align="left" width='200'>
				<select id="class" class="select">
				<?php 
				foreach($classinfo as $k=>$v){
					echo "<option value='{$v['id']}'>{$v['classname']}</option>";
				}?>
				</select>
			</td>
			<td align="right" width='60' height='36'>宽度：</td>
			<td width="60">
				<input type="text" id="width" class="inp" placeholder="如:100px 或 100%" value="100%">
			</td>
			<td align="right" width='60' height='36'>高度：</td>
			<td width="60">
				<input type="text" id="height" class="inp" placeholder="如:100px 或 100%" value="414px">
			</td>
			<td width="*"><button onclick="_create();">生成</button></td>
		</tr>
		
		
		<tr>
			<td align="left" colspan="9">
			<textarea id="code" style="width:100%;height:200px;box-sizing:border-box;"></textarea>
			</td>
		</tr>
		<tr>
			<td align="left" colspan="9" style="color:#A25030">
			在您的网页中设定好订单入口位置(定位、长度、宽度)，复制上面生成的代码到入口位置即可。<span style='color:red;'>系统不受域限制，可以在任意网站中调用！</span> <a style="color:green;" href="http://wpa.qq.com/msgrd?v=3&amp;uin=10287093&amp;site=qq&amp;menu=yes" title="QQ在线咨询" target="_blank">更多风格请联系QQ：10287093</a>
			</td>
		</tr>
	</tbody>
</table>


<iframe scrolling="no" style="width:100%;height:600px;border:0;box-sizing:border-box" id="iframe" src="getcode_view.php"></iframe>


</body>
</html>