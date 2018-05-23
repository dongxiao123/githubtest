<?php
class LYG{
	public static function ShowMsg($msg){
		header("Content-type:text/html;charset=utf-8");
		echo "<script type='text/javascript'>alert('".$msg."');history.go(-1);</script>";
		exit;
	}
	
	public static function checklogin(){
		if(!isset($_SESSION['username']) || !isset($_SESSION['uid'])){
			echo "<script type='text/javascript'>window.open('./','_top');</script>";
			exit;
		}
	}

    /**
     * 判断是否是超级管理员
     * @author：dongx
     * @return bool
     */
    public static function isAdmin()
    {
        if (isset($_SESSION['username']) && $_SESSION['uid'] == 1)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    /**
     * 校验必填参数
     * @param array $arr $arr
     *
     * @author：dongx
     * @return string
     */
    public static function checkRequired($arr)
    {
        $str = true;
        foreach ($arr as $k => $v)
        {
            if (!isset($_REQUEST[$k]) || trim($_REQUEST[$k]) == '')
            {
                $str .= ',' . $v;
            }
        }
        if ($str !== true)
        {
            $str = trim($str, ',');
        }

        return $str;


    }
	//根据记录总数获取总分页数
	public static function getTotalPage($totalcount,$pagesize=10){
		if($totalcount<1){return 0;}
		if($totalcount%$pagesize==0){
			$totalpage=$totalcount/$pagesize;
		}else{
			$totalpage=($totalcount-($totalcount%$pagesize))/$pagesize+1;
		}
		return $totalpage;
	}
	//获取分页代码（当前页，总记录数，分页宽，参数数组{[n=1],[x=2]}）
	public static function getPageHtml($currentpage,$totalcount,$pagesize=10,$pm=""){
		$pagesizearr = array(
			10,20,50,100,200,500,1000
		);
		$pagesizehtml_options="";
		foreach($pagesizearr as $a){
			if($a==$pagesize){
				$pagesizehtml_options.="<option value='{$a}' selected='selected'>{$a}</option>";
			}else{
				$pagesizehtml_options.="<option value='{$a}'>{$a}</option>";
			}
		}
		$pagesizehtml="<select id='pagesize' class='pagesize'>{$pagesizehtml_options}</select>";
		
		$pagerange=3;		//分页宽度
		$totalpage=0;		//总页数
		//	x条记录  << 5 >> 共y页
		if($totalcount<=$pagesize){
			return "<a class='thispage'>共 $totalcount 条记录</a>　每页{$pagesizehtml}条";
		}
		//总页数
		if($totalcount%$pagesize==0){
			$totalpage=$totalcount/$pagesize;
		}else{
			$totalpage=($totalcount-($totalcount%$pagesize))/$pagesize+1;
		}
		$startpage=$currentpage-$pagerange>0?$currentpage-$pagerange:1;
		$endpage=$currentpage+$pagerange<$totalpage?$currentpage+$pagerange:$totalpage;
		//参数绑定
		$canshu = array();
		if(is_array($pm) && count($pm)>0){
			$canshu = $pm;
		}
		//头部
		$page='<a>共 '.$totalcount.'条记录</a>';
		//当前分页前
		for($i=$startpage;$i<$currentpage;$i++){
			$tmp = $canshu;
			$tmp[]="p=$i";
			$cs = implode("&",$tmp);
			$page.="<a href='?{$cs}'>$i</a>";
		}
		//当前分页
		$page.='<a class="thispage">'.$currentpage.'</a>';
		//当前分页后
		for($i=$currentpage+1;$i<=$endpage;$i++){
			$tmp = $canshu;
			$tmp[]="p=$i";
			$cs = implode("&",$tmp);
			$page.="<a href='?{$cs}'>$i</a>";
		}
		//总页数
		$page.="<a>共{$totalpage}页</a>　每页{$pagesizehtml}条";
		return '<div class="pages">'.$page.'</div>';
	}
	
	//写配置文件
	public static function saveConfig($filename,$data=array()){
		$fpath = dirname(dirname(__FILE__))."/config/".$filename;
		$myfile = fopen($fpath, "w");
		$txt = json_encode($data);
		fwrite($myfile, "<?php die();?>{$txt}");
		fclose($myfile);
	}
	//读配置文件
	public static function readConfig($filename){
		$fpath = dirname(dirname(__FILE__))."/config/".$filename;
		if(is_readable($fpath)===false){
			return null;
		}
		$myfile = fopen($fpath, "r");
		$txt = fread($myfile,filesize($fpath));
		fclose($myfile);
		$txt = substr($txt,14);
		return json_decode($txt,true);
	}
	
	//更新数据库json配置
	public static function setjson($flag='',$data=array()){
		global $con;
		$_value = array(
			'flag'=>$flag,
			'json'=>json_encode($data)
		);
		$json = $con->find("select * from #__json where flag='{$flag}'");
		
		$eok = false;
		if(empty($json)){
			$eok = $con->add("json",$_value);
		}else{
			$eok = $con->update("update #__json set json=? where flag='{$flag}'",array(json_encode($data)));
		}
		if($eok){
			return true;
		}else{
			return false;
		}
	}
	//获取数据库json配置
	public static function getjson($flag=''){
		global $con;
		$json = $con->find("select * from #__json where flag='{$flag}'");
		return json_decode($json['json'],true);
	}
	//获取客户端IP
	public static function getIP() { 
		if(isset($_SERVER)){
			if(isset($_SERVER['HTTP_X_FORWARDED_FOR'])){
				$realip = $_SERVER['HTTP_X_FORWARDED_FOR'];
			}elseif(isset($_SERVER['HTTP_CLIENT_IP'])){
				$realip = $_SERVER['HTTP_CLIENT_IP'];
			}else{
				$realip = $_SERVER['REMOTE_ADDR'];
			}
		}else{
			if(getenv("HTTP_X_FORWARDED_FOR")){
				$realip = getenv( "HTTP_X_FORWARDED_FOR");
			}elseif (getenv("HTTP_CLIENT_IP")){
				$realip = getenv("HTTP_CLIENT_IP");
			}else{
				$realip = getenv("REMOTE_ADDR");
			}
		}
		$arr = explode(",",trim($realip));
		foreach($arr as $o){
			if(preg_match("/^[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}$/",$o)){
				return $o;
			}
		}
		return "unknown";
	}
	//写操作日志
	public static function writeLog($info){
		global $con;
		$data = array(
			'addtime'=>time(),
			'info'=>$info
		);
		$con->add("log",$data);
	}
	
}
date_default_timezone_set('PRC');
?>