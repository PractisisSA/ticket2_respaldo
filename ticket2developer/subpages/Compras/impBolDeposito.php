<?php
	session_start();
	$cadaBoleto = $_REQUEST['cadaBoleto'];
	echo $_SESSION['content2'];
	echo '<tr style="font-family:corbel;">
			<td>
				<br>
				Su código de compra es : '.$cadaBoleto.'
			</td>
		</tr>';
	echo $_SESSION['content3'];
?>