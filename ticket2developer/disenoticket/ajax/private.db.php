<?php
	class DBConn extends PDO{
		public function __construct(){
			$host= '104.131.65.202';
			$dbname = 'ticket';
			$user = 'root';
			$pass = 'zuleta99';

			parent::__construct('mysql: host='.$host.'; dbname='.$dbname, $user, $pass);
			$this -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$this -> setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
		}
	}
?>