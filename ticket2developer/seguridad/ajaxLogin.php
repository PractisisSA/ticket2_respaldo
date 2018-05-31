<?php
	session_start();
	if($_REQUEST['username']=='seguridad@tf.com'&&$_REQUEST['pass']=='54321'){
		$_SESSION['admin']=1;
		echo "ok";
	}else{
		echo "error";
	}
?> 