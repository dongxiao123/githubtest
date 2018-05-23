<?php
session_start();
require('include/mysql.php');
require('include/function.php');
LYG::checklogin();


$pagesize = lyg::getjson("data_pagesize");//每页显示数量
$pagesize = $pagesize['pagesize'];

//总记录数
$datacount=$con->RowsCount("select count(*) from #__goods");
//总页数
$totalpages=LYG::getTotalPage($datacount,$pagesize);
$page=1;
if(isset($_GET['p']) && intval($_GET['p'])>0){
	$page=intval($_GET['p']);
	$page=$page>$totalpages?$totalpages:$page;
	if($page+1<=1){$page=1;}
}
$start_id=($page-1)*$pagesize;
//查询数据
$sql="select #__goods.*,#__class.classname from #__goods left join #__class on #__class.id = #__goods.class_id order by #__goods.id desc limit $start_id,$pagesize";
$data	=$con->select($sql);

//得到分页HTML
$fenye=LYG::getPageHtml($page,$datacount,$pagesize);

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>商品管理</title>
<link href="style/css.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/common.js"></script>
</head>

<body class="content">


<table cellpadding="3" cellspacing="0">
	<thead>
    	<tr>
            <th width="100">#</th>
            <th width="*">商品名</th>
            <th width="100">价格</th>
            <th width="100">库存</th>
            <th width="200">所属分类</th>
            <th width="100">-</th>
        </tr>
    </thead>
    <tbody>
	<?php foreach($data as $k=>$v){?>
    	<tr class='list'>
        	<td align="center">
			<?php 
				echo "<a class='edit' href='goods_edit.php?id={$v['id']}' title='点击进入修改'>{$v['id']}</a>";
			?>			
			</td>
        	<td align="center"><?php echo $v['goods'];?></td>
        	<td align="center"><?php echo floatval($v['price']);?></td>
        	<td align="center"><?php echo $v['stock'];?></td>
        	<td align="center"><?php echo $v['classname'];?></td>
            <td align="center">
				<a onclick="return confirm('确定删除吗？');" class="del" href="goods_del.php?<?php echo 'id='.$v['id'];?>">删除</a>
			</td>
        </tr>
	<?php }?>
    </tbody>
    <tfoot>
    	<tr>
        	<td colspan="6" style="padding-left:30px;">
			<?php echo $fenye ;?>
			</td>
        </tr>
    </tfoot>
</table>

<p class="toadd"><a href="goods_add.php">添加商品</a></p>

</body>
</html>