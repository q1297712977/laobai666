<?php

class Dao{
	//属性：保存PDO对象
	private $pdo;

	//初始化对象
	private function __construct($dbinfo = array(),$drivers = array()){
		//初始化
		$type = $dbinfo['type'] ?? 'mysql';
		$host = $dbinfo['host'] ?? '127.0.0.1';
		$port = $dbinfo['port'] ?? '3306';
		$dbname = $dbinfo['dbname'] ?? 'test';
		$charset = $dbinfo['charset'] ?? 'utf8';
		$user = $dbinfo['user'] ?? 'root';
		$pass = $dbinfo['pass'] ?? '111111';

		//限定错误处理模式为异常模式
		$drivers[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;

		//1、 得到对象：短路运算
		try{
			$this->pdo = @new PDO("{$type}:host={$host};port={$port};dbname={$dbname};charset={$charset}",$user,$pass,$drivers);
		}catch(PDOException $e){
			//正常处理：将错误信息写入到错误日志中
			echo '数据库连接认证失败！<br/>';
			echo '错误文件是：' 	. $e->getFile() 	. '<br/>';
			echo '错误行是：' 	. $e->getLine() 	. '<br/>';
			echo '错误原因是：' 	. $e->getMessage() 	. '<br/>';
			exit;
		}
		
	}

	//单例
	private static $obj = NULL;
	public static function getDao($dbinfo = array(),$drivers = array()){
		//判定是否需要重新产生对象
		if(!self::$obj instanceof self) self::$obj = new self($dbinfo,$drivers);

		//返回对象
		return self::$obj;
	}

	//私有化克隆方法
	private function __clone(){}

	/*
	 * 写操作
	 * @parma1 string $sql，要执行的SQL指令
	 * @return 受影响的行数
	*/
	public function dao_exec($sql){
		//执行SQL
		try{
			$res = $this->pdo->exec($sql);
		}catch(PDOException $e){
			echo 'SQL执行失败！<br/>';
			echo '错误文件是：' 	. $e->getFile() 	. '<br/>';
			echo '错误行是：' 	. $e->getLine() 	. '<br/>';
			echo '错误原因是：' 	. $e->getMessage() 	. '<br/>';
			exit;
		}
		
		//返回：受影响的行数
		return $res;	
	}

	//获取自增长id
	public function dao_insertId(){
		//直接调用PDO方法
		return $this->pdo->lastInsertId();
	}


	//读操作：进行SQL错误语法检查
	private function dao_query($sql){
		try{
			$stmt = $this->pdo->query($sql);

		}catch(PDOException $e){
			echo 'SQL执行失败！<br/>';
			echo '错误文件是：' 	. $e->getFile() 	. '<br/>';
			echo '错误行是：' 	. $e->getLine() 	. '<br/>';
			echo '错误原因是：' 	. $e->getMessage() 	. '<br/>';
			exit;
		}
		//没有问题
		return $stmt;
	}


	/*
	 * 从PDOStatement对象中解析结果
	 * @param1 string $sql，要执行的SQL指令
	 * @param2 bool $one = true，默认获取一条记录
	 * @param3 int $style = PDO::FETCH_ASSOC，获取数据的方式（默认是关联数组）
	 * @return 成功返回数组，失败返回的false
	*/
	public function dao_read($sql,$one = true,$style = PDO::FETCH_ASSOC){
		//内部调用SQL验证
		$stmt = $this->dao_query($sql);

		//只需要根据条件解析结果即可
		if($one){
			//获取一条记录
			return $stmt->fetch($style);
		}else{
			//获取多条记录：自己利用fetch方法+循环实现获取全部
			return $stmt->fetchAll($style);
		}
	}

}
