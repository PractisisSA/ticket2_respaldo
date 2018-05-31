<?php

	$close = $_REQUEST['close'];
	if ($close == 1) {
		session_start();
		session_destroy();
	}

?>