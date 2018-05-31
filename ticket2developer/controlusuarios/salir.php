<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<script src="https://apis.google.com/js/platform.js" async defer></script>
<meta name="google-signin-client_id" content="888800978669-1b5su9godmrs85vitb0v36cdd0ft7mfa.apps.googleusercontent.com">
<script>
	function signOut() {
		var auth2 = gapi.auth2.getAuthInstance();
		auth2.signOut().then(function () {
		console.log('User signed out.');
		});
	}
</script>


<?php 
	session_start();
	session_destroy();
	header("Location: ../?modulo=start");
?>
