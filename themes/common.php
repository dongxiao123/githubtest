<?php
require_once('../../include/mysql.php');
//分类ID
$class_id = 0;
if(empty($_GET['class']) || intval($_GET['class'])<1){
	die('error 002');
}
$class_id = intval($_GET['class']);
//分类信息
$classinfo = $con->find("select * from #__class where id=$class_id");
if(empty($classinfo) || intval($classinfo)<1){die('error 003');}
//商品信息
$goodsinfo = $con->select("select * from #__goods where class_id=$class_id");

$referer = empty($_GET['ref'])?'未知':$_GET['ref'];
?>