<?php require_once('../common.php');?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="initial-scale=1, maximum-scale=1, user-scalable=no">
<title>尚新客户订单详情提交</title>
<script type="text/javascript" src="../../js/jquery.min.js"></script>
<script type="text/javascript">
var _ref = "<?php echo $referer;?>";
</script>
<script type="text/javascript" src="../common.js"></script>
<style type="text/css">
*{
	margin:0;padding:0; outline:0; font-family: 'Microsoft Yahei'; box-sizing: border-box;
}
body{
	background:#fff
}
.order-title{ 
	font-size:14px; line-height: 1em; font-weight: normal; padding:10px 10px; background: blue; color:#fff; 
}
table{ 
	width: 100%; margin-top:20px; 
}
td{ 
	padding:3px 3px; font-size:14px; 
}
select{
	width: 50%; height: 30px; border-radius: 3px; border:1px solid #ccc;
}
dl{
	overflow: hidden;
}
dl dt{ 
	float: left;display: inline-block; line-height: 1em; font-weight:bold;
	padding:7px; cursor: default; background: #E2DFDF;
	-webkit-touch-callout: none; 
	-webkit-user-select: none; 
	-khtml-user-select: none; 
	-moz-user-select: none; 
	-ms-user-select: none; 
	user-select: none; 
 }
dl dt:nth-child(1){ 
	border-width: 1px 0 1px 1px; border-style: solid; border-color: #ccc; border-top-left-radius: 3px;
	border-bottom-left-radius: 3px;
}
dl dt:nth-child(3){ 
	border-width: 1px 1px 1px 0; border-style: solid; border-color: #ccc;
	border-top-right-radius: 3px;
	border-bottom-right-radius: 3px;
}
dl dd{ 
	float: left;display: inline-block; 
}
input.text{ 
	width: 90%; height: 30px; border:1px solid #ccc; border-radius: 3px; padding:0 3px; 
}
input.shuliang{ 
	width: 60px; text-align: center; border-radius: 0; font-weight: bold; color: red; 
}
textarea{ 
	width: 90%; height: 70px; border:1px solid #ccc; border-radius: 3px;resize:none; padding:3px; 
}
#total{ 
	color: red; font-size: 16px;
}
#submit{
	border:0; background: blue; color:#fff; font-size: 14px; line-height: 1em;padding:10px 40px; 
	border-radius: 3px; 
}
#loading{ 
	position: fixed; width: 100%; height: 100%; left: 0; top: 0; z-index: 9999999999999999; 
}
#loading span{
	display:block;position: absolute;  width:50px; height: 50px; left: 50%; 
	margin-left: -25px; top: 50%; margin-top: -25px; 
}
#loading span:before{
	content: '';display: block; width: 10px; height:10px; 
	position: absolute; right:50%; top: 50%;margin-top:-5px;
	background:#0086C9; border-radius: 50%;
	animation:fangda 1s infinite;
	-webkit-animation:fangda 1s infinite;
}
#loading span:after{
	content: '';display: block; width: 20px; height:20px; 
	position: absolute; left:50%; top: 50%;margin-top:-10px;
	background:#64D214; border-radius: 50%;
	animation:suoxiao 1s infinite;
	-webkit-animation:suoxiao 1s infinite;
}
@keyframes fangda{
	50% {width: 20px; height: 20px; margin-top:-10px;}
}
@-webkit-keyframes fangda{
	50% {width: 20px; height: 20px; margin-top:-10px;}
}
@keyframes suoxiao{
	50% {width: 10px; height: 10px; margin-top:-5px;}
}
@-webkit-keyframes suoxiao{
	50% {width: 10px; height: 10px; margin-top:-5px;}
}
</style>

</head>

<body>

<h2 class='order-title'>在线订购<?php echo $classinfo['classname'];?></h2>

<table cellspacing="0">
	<tr>
		<td width="100" align="right">商品</td>
		<td width="*">
			<select id="goods_id">
			<?php
			foreach ($goodsinfo as $k => $v) {
				echo "<option value='{$v['id']}'>{$v['goods']}</option>";
			}
			?>
			</select>
		</td>
	</tr>
	<tr>
		<td align="right">订购数量</td>
		<td>
			<dl>
				<dt onclick="shuliang(-1);">-</dt>
				<dd><input type="text" id="shuliang" class="text shuliang" value="1"></dd>
				<dt onclick="shuliang(1);">+</dt>
			</dl>
		</td>
	</tr>
	<tr>
		<td align="right">称呼</td>
		<td><input type="text" class="text" id="xingming" placeholder="您的姓名"></td>
	</tr>
	<tr>
		<td align="right">电话</td>
		<td><input type="text" class="text" id="dianhua" placeholder="您的手机号码"></td>
	</tr>
	<tr>
		<td align="right">收货地址</td>
		<td><input type="text" class="text" id="dizhi" placeholder="请输入准确的收货地址"></td>
	</tr>
	<tr>
		<td align="right">留言</td>
		<td><textarea id="liuyan"></textarea></td>
	</tr>
	<tr>
		<td align="right">合计</td>
		<td>￥<b id="total">-</b></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td><button id="submit">提交订单</button></td>
	</tr>
</table>




</body>
</html>