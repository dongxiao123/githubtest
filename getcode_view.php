<?php
$html = "<p style='font-size:36px;color:#999999; text-align:center;font-family:microsoft Yahei;padding-top:200px;'>预览区</p>";
if(!empty($_GET['url'])){
	$html = $_GET['url'];
	$html="<script type='text/javascript' src='{$html}'></script>";
}
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="initial-scale=1, maximum-scale=1, user-scalable=no">
<title>提交订单-七歌工作室</title>
</head>
<style type="text/css">
*{ margin: 0; padding: 0; }
body{ text-align: center; background:#ccc }
.box{ width: 100%; max-width: 750px; margin: 0 auto; }
iframe{width: 100%; border: 0 }
</style>
<body>

<div class="box" id="box">
	<?php
	echo $html;
	?>
	
</div>



</body>
</html>