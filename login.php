<?php
if ( session_status() == PHP_SESSION_NONE ){
	session_start();
}
require_once( '/conf/config.php' );
?>

<html>

<head>
	<meta charset='UTF-8'>
	<title>教室預借系統</title>
	<link rel='stylesheet' href='/css/bootstrap.min.css'>
	<link rel='stylesheet' href='/css/font-awesome.min.css'>
	<link rel='stylesheet' href='/css/navbar.css'>
	<script src='/js/bootstrap.min.js'></script>
	<script src='/js/jquery.min.js'></script>
	<script src='/js/main.js'></script>
</head>

<body>
	<?php include('navbar.php'); ?>
	<form id='loginForm' method='post' action='login_com.php'>
        <div class='container' style="margin-top: 20px;">
        <div class="form-group">
            <label for="exampleInputEmail1">帳號</label>
                <input type="text" class="form-control" name='username' placeholder='輸入帳號'>
        </div>
        <div class="form-group">
            <label for="exampleInputPassword1">密碼</label>
            <input type='password' class="form-control" name='password' placeholder='輸入密碼'>
        </div>
		<input type='submit' class='btn btn-success' name='submit' value='登入'>
        </div>
	</form>
</body>

</html>