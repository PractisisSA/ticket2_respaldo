<?php 
	@session_start();
	if($_SESSION["autentica"] != "tFDiS759"){
		echo "
			<script>
				alert('Debes iniciar sesion para acceder');
				window.location.href = '?modulo=start';
			</script>
		";
		exit();
	}
?>