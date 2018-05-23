<?php
//数据库操作类
require_once("mysql.config.php");
class mySQLHelper{
	private $host	='';
	private $dbname	='';
	private $uid	='';
	private $pwd	='';
	private $port	='';
	private $prefix	='';
	private	$con;
	function __construct(){
		global $_mysql_config;
		$this->host		= $_mysql_config['host'];
		$this->dbname	= $_mysql_config['dbname'];
		$this->uid		= $_mysql_config['uid'];
		$this->pwd		= $_mysql_config['pwd'];
		$this->port		= $_mysql_config['port'];
		$this->prefix	= $_mysql_config['prefix'];
		try{
			$this->con = new PDO(
				"mysql:host={$this->host};port={$this->port};dbname={$this->dbname}",
				$this->uid,
				$this->pwd,
				array(PDO::MYSQL_ATTR_INIT_COMMAND => "set names 'utf8';")
			);
		}catch(Exception $e){
			die('MySQL error');
		}
	}
	public function begin(){
		$this->con->beginTransaction();
	}
	public function back(){
		$this->con->rollBack();
	}
	public function done(){
		$this->con->commit();
	}
	//返回结果集合，失败返回null(select)
	private function MyQuery($sql){
		$sql = str_replace('#__',$this->prefix,$sql);
		$data=$this->con->query($sql);		
		//默认两种方式体现
		if($data)
			return $data->fetchAll();
		else
			return null;
	}
	public function select($sql,$arr=array()){
		$sql = str_replace('#__',$this->prefix,$sql);
		$dp=$this->con->prepare($sql);		
		if(is_array($arr)){
			for($i=1;$i<=count($arr);$i++){
				$dp->bindParam($i,$arr[$i-1]);
			}
		}
		$dp->execute();
		if($dp){
			return $dp->fetchAll(PDO::FETCH_ASSOC);			
		}else{
			return null;
		}
	}
	public function find($sql,$arr=array()){
		$items = $this->select($sql,$arr);
		if($items && count($items)>0){
			return $items[0];
		}else{
			return null;
		}
	}
	//参数方式执行(insert,delete,update,select)，防止SQL注入，可自动处理特殊符号 如：单引号，双引号
	private function Prepare($sql,$arr=array()){
		$sql = str_replace('#__',$this->prefix,$sql);
		$dp=$this->con->prepare($sql);
		if(is_array($arr)){
			for($i=1;$i<=count($arr);$i++){
				$dp->bindParam($i,$arr[$i-1]);
			}
		}
		return $dp->execute();
	}
	//返回最新ID的参数化方法(如：insert)
	public function Insert($sql,$arr=array()){
		$sql = str_replace('#__',$this->prefix,$sql);
		$dp=$this->con->prepare($sql);
		if(is_array($arr)){
			for($i=1;$i<=count($arr);$i++){
				$dp->bindParam($i,$arr[$i-1]);
			}
		}
		$dp->execute();
		return $this->con->lastInsertId();
	}
	public function add($tablename,$data=array()){
		$fields = array();
		$wen = "";//问号  ?
		$zhi = array();
		foreach($data as $k=>$v){
			$fields[] = $k;
			$zhi [] = $v;
			$wen.=$wen==''?'?':',?';
		}
		$fields = implode(',',$fields);
		$sql = "insert into #__{$tablename}({$fields}) values({$wen})";
		return $this->insert($sql,$zhi);
	}
	//返回最新ID的参数化方法(如：insert)
	public function Update($sql,$arr=array()){
		$sql = str_replace('#__',$this->prefix,$sql);
		$dp=$this->con->prepare($sql);
		if(is_array($arr)){
			for($i=1;$i<=count($arr);$i++){
				$dp->bindParam($i,$arr[$i-1]);
			}
		}
		return $dp->execute();
	}
	
	//返回受影响行数(insert,delete,update)
	public function Excute($sql){
		$sql = str_replace('#__',$this->prefix,$sql);
		$rows=$this->con->exec($sql);
		return $rows;
	}
		
	//满足条件数量统计(select count(*) ... )
    public function RowsCount($sql,$arr=array()){
		$sql = str_replace('#__',$this->prefix,$sql);
        try{
            $dp=$this->con->prepare($sql);       
            if(is_array($arr)){
                for($i=1;$i<=count($arr);$i++){
                    $dp->bindParam($i,$arr[$i-1]);
                }
            }
            $dp->execute();
            if($dp){
                $x = $dp->fetchColumn();
                return intval($x);
            }
            return 0;
        }catch(Exception $e){
            die("Error");
        }
    }
}

$con = new mySQLHelper;

?>