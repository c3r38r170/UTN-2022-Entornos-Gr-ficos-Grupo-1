<?php

class MysqliWrapper{
	var $dblink;
	var $error;

	function __construct(){
		$data=parse_ini_file('db.ini');
		$this->dblink = new mysqli($data['host'],$data['user'],$data['password'],$data['database']);//$dbhost, $dbuser, $dbpass, $dbname);
		$this->dblink->set_charset("utf8");
		register_shutdown_function(array(&$this, 'destruct'));
	}
	function destruct(){
		$this->dblink->close();
	}

	function query($q){
		$result=$this->dblink->query($q);
		if($this->dblink->error){
			throw new Exception("MySQL error {$this->dblink->error}
Query: \"$q\"
",$this->dblink->errno);
		}
		return $result;
	}
	function prepared($query,$data){
		if($s=$this->dblink->prepare($query)){
			$error=false;
			if($s->bind_param(str_repeat('s',count($data)),...$data))
				if($s->execute())
					switch(strtoupper(substr($query,0,3))){
						case 'INS':
						case 'UPD':
						case 'DEL':
							$data=$s->affected_rows;
							$s->close();
							return $data;
							break;
						case 'SEL':
							$data=$s->get_result();
							$s->close();
							return $data?:false;
							break;
						default:
							$this->error='Not prepared statement-supported query type.';
							break;
					}
				else $error=true;
			else $error=true;
			if($error)
				$this->error=$s->error;
			return false;
		}else $this->error=$this->dblink->error;
		return false;
	}
	
	function insert_id(){
		return $this->dblink->insert_id;
	}
}

$db=new MysqliWrapper();

?>