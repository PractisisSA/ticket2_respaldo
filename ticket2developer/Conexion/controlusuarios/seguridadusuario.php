<?php 
	@session_start();
	if($_SESSION["autentica"] != "uzx153"){
		echo "
			<script>
				alert('Debes iniciar sesion para acceder');
				window.location.href = '?modulo=start';
			</script>
		";
		exit();
	}
?>