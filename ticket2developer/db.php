<?php 
	class Db{
		public static function connect(){
			if(!$link = mysql_connect(DB_HOST,DB_USER,DB_PASS)){
				die('Error');
			}
			if(!$mysql_select_db(DB_NAME)){
				die('Error DB');
			}
			
			return $link;
		}
	}
?>