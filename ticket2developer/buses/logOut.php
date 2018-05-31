<?php   
session_start(); //to ensure you are using same session
session_destroy(); //destroy the session
echo'<script>
		window.location="index.php"
	</script>';
exit();
?>