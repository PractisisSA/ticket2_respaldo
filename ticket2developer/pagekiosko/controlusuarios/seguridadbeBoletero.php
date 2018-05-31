<?php 
	@session_start();
	if($_SESSION["autentica"] != "jag123"){
		echo "
			<script>
				alert('Debes iniciar sesion para acceder');
				window.location.href = '?modulo=start';
			</script>
		";
		exit();
	}
?>