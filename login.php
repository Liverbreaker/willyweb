<?php
if ( session_status() == PHP_SESSION_NONE ){
	session_start();
}
require_once( 'config.php' );
?>

<html>

<head>
	<meta charset='UTF-8'>
	<title>教室預借系統</title>
	<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css'>
	<link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css'>
	<link rel='stylesheet' href='css/navbar.css'>
	<script src='//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js'></script>
	<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.0/jquery.min.js'></script>
	<script type='text/javascript' src='js/main.js'></script>
</head>

<body>
	<?php include('navbar.php'); ?>
	<form id='loginForm' method='post' action='login_com.php'>
		帳號:<br>
		<input type='text' name='username'><br>
		密碼:<br>
		<input type='password' name='password'><br>
		<input type='submit' name='submit' value='登入'>
	</form>
</body>

</html>