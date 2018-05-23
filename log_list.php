<?php
session_start();
require('include/mysql.php');
require('include/function.php');
LYG::checklogin();

$pagesize = lyg::getjson("data_pagesize");//每页显示数量
$pagesize = $pagesize['pagesize'];

//总记录数
$datacount=$con->RowsCount("select count(*) from #__log");
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
$sql='select * from #__log order by id desc limit '.$start_id.','.$pagesize;
$data	=$con->select($sql);
//得到分页HTML
$fenye=LYG::getPageHtml($page,$datacount,$pagesize);

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>系统日志</title>
<link href="style/css.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/common.js"></script>
</head>

<body class="content">

<table cellpadding="3" cellspacing="0">
	<thead>
    	<tr>
            <th width="100">#</th>
            <th width="*">信息</th>
            <th width="300">时间</th>
        </tr>
    </thead>
    <tbody>
	<?php foreach($data as $k=>$v){?>
    	<tr class='list'>
        	<td align="center">
				<?php echo $v['id'];?>
			</td>
        	<td align="center"><?php echo $v['info'];?></td>
        	<td align="center"><?php echo date('Y-m-d H:i:s',$v['addtime']);?></td>
        </tr>
	<?php }?>
    </tbody>
    <tfoot>
    	<tr>
        	<td colspan="3" style="padding-left:30px;">
			<?php echo $fenye ;?>
			</td>
        </tr>
    </tfoot>
</table>


</body>
</html>