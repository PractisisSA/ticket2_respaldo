	<!DOCTYPE html>
		<html lang="en">
			<head>
				<meta charset="utf-8">
				<meta http-equiv="X-UA-Compatible" content="IE=edge">
				<meta name="viewport" content="width=device-width, initial-scale=1">
				<title>Camara</title>
				<link href="css/bootstrap.min.css" rel="stylesheet">
				<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
				<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">
				
				<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
				<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
				<script src="jquery.webcam.js"></script>
				<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
				<script src="//code.jquery.com/jquery-1.10.2.js"></script>
				<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
				<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
				<script>
					$( document ).ready(function() {
						console.log( "ready!" );
						setTimeout(function() {
							$( "#photo" ).trigger( "click" );
						}, 3000);
						setTimeout(function() {
							sendToServer();
						}, 4000);
					});
					
					function sendToServer() {
						var data = canvas.toDataURL('image/png');
						$.post('prosesar.php',{
							data : data
						}).done(function(data){
							if($.trim(data)==0){
								alert('Error por favor vuelva a tomar la foto ');
							}else{
								alert('foto guardada con exito');
								setTimeout(function() {
									$('#smsCedula').show('slide',600);
								}, 2000);
							}
						});
					  }
					  function cedula(){
						  $( "#photo" ).trigger( "click" );
						  setTimeout(function() {
								sendToServer();
							}, 2000);
					  }
				</script>
			</head>
			<body>
				<div class='row'>
					<div class='col-md-2'></div>
					<div class='col-md-8' style='border:2px solid #eee;padding-top:30px;padding-bottom:30px;'>
						<div class='row'>
							<div class='col-xs-2'>
								<div id='smsCedula' style='margin-top:300px;padding-left:10px;padding-rigth:10px;padding-bottom:20px;padding-top:20px;display:none;background: #fbfbfb none repeat scroll 0 0;border-radius: 10px;box-shadow: 0 5px 6px 3px rgba(0, 0, 0, 0.5);transform: translate3d(0px, -30px, 0px);z-index: 99;'>
									por favor ponga su cedula con la foto hacia abajo en el escaner para validar su identidad<br/>
									y presione <br/><br/>
									<button type="button" class="btn btn-success btn-xs" onclick='cedula()' >Continuar</button>
									
								</div>
							</div>
							<div class='col-xs-8'>
								<div id='contieneCamara' style='margin:0auto;padding:30px;background:#fbfbfb none repeat scroll 0 0;border-radius: 10px;box-shadow: 0 5px 6px 3px rgba(0, 0, 0, 0.5);transform: translate3d(0px, 5px, 0px);z-index: 99;text-align:center;'>
									<center>
										<img src='img/cam.png'>
									</center><br/>
									<video id="video" width="85%" height="400px" autoplay="autoplay" ></video>
									<button id="photo" style='display:none;'>Take a Photo!</button>
								</div>
								
							</div>
							<div class='col-xs-2'></div>
						</div>
					</div>	
					<div class='col-md-2'>
						
					</div>
				</div>
				<div class='row'>
					<div class='col-md-2'></div>
					<div class='col-md-8'>
						<div id='fotoTomada'></div>
					</div>
					<div class='col-md-2'></div>
				</div>
				<center>
					<button id="send" style='display:none;'>Take a Photo!</button>
				</center>
				<center>
					<canvas id="canvas" width="450" height="368" style="display:;"></canvas>
				</center>
			</body>
		</html>