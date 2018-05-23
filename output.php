<?php
set_time_limit(0);
$totalcount = count($data);
//创建、设置Excel
$objPHPExcel = new PHPExcel();
$objPHPExcel->getProperties()
	->setCreator("7gee.cc")
	->setLastModifiedBy("7gee.cc")
	->setTitle("PHPExcel Test Document")
	->setSubject("PHPExcel Test Document")
	->setDescription("Test document for PHPExcel, generated using PHP classes.")
	->setKeywords("office PHPExcel php")
	->setCategory("Test result file");
//设置宽度
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(30);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(12);
$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(50);
$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(50);

//设置C列(电话)为文本格式
$objPHPExcel->getActiveSheet()->getStyle('C')->getNumberFormat()
	->setFormatCode("@");
	//->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
	
//第一行
$objPHPExcel->getActiveSheet()->mergeCells('A1:L1');//合并单元格
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', "订单数据");
//第二行
$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('A2', 'ID')
			->setCellValue('B2', '姓名')
			->setCellValue('C2', '电话')
			->setCellValue('D2', '商品')
			->setCellValue('E2', '分类')
			->setCellValue('F2', '单价')
			->setCellValue('G2', '数量')
			->setCellValue('H2', '总金额')
			->setCellValue('I2', '订单时间')
			->setCellValue('J2', '状态')
			->setCellValue('K2', '地址')
			->setCellValue('L2', '来路');
$index = 3;
foreach($data as $k=>$v){
	$t = intval($v['addtime'])<1?'':date('Y-m-d H:i:s',$v['addtime']);
	$s = '未处理';
	if(intval($v['status'])===1){
		$s='处理中';
	}else if(intval($v['status'])===2){
		$s='完成';
	}
	$g = sprintf('%.2f',floatval($v['price'])*intval($v['shuliang']));
	
	$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue('A'.$index, $v['id'])
		->setCellValue('B'.$index, $v['kehu'])
		->setCellValue('C'.$index, $v['dianhua'])
		->setCellValue('D'.$index, $v['goods'])
		->setCellValue('E'.$index, $v['classname'])
		->setCellValue('F'.$index, $v['price'])
		->setCellValue('G'.$index, $v['shuliang'])
		->setCellValue('H'.$index, $g)
		->setCellValue('I'.$index, $t)
		->setCellValue('J'.$index, $s)
		->setCellValue('K'.$index, $v['dizhi'])
		->setCellValue('L'.$index, $v['referer']);
	$index++;
}
// 表名称
$objPHPExcel->getActiveSheet()->setTitle('订单数据');
// 设置第一张表为活跃表
$objPHPExcel->setActiveSheetIndex(0);
//第一种直接保存
//$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
//$objWriter->save('shite.xlsx');//这种方式默认保存在php文件同一文件夹下
//die();
//第二种弹窗式保存
ob_end_clean();//清除缓冲区,避免乱码
header("Pragma: public");
header("Expires: 0");
header("Cache-Control:must-revalidate, post-check=0, pre-check=0");
header("Content-Type:application/force-download");
header("Content-Type:application/vnd.ms-execl");
header("Content-Type:application/octet-stream");
header("Content-Type:application/download");;
header('Content-Disposition:attachment;filename="data.xlsx"');
header("Content-Transfer-Encoding:binary");
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');