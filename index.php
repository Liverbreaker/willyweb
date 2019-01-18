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
	<link rel="stylesheet" href="/css/bootstrap.min.css">
	<link rel='stylesheet' href='/css/font-awesome.min.css'>
	<link rel='stylesheet' href='/css/navbar.css'>
	<link rel='stylesheet' href='/css/cal/fullcalendar.css' />
	<link rel='stylesheet' href='/css/cal/scheduler.css' />
	
	<script src="/js/jquery.min.js"></script>
	<script src="/js/bootstrap.min.js"></script>
	<script src='/js/main.js'></script>
	<script src='/js/cal/moment.min.js'></script>
	<script src='/js/cal/fullcalendar.js'></script>
	<script src='/js/cal/scheduler.js'></script>

</head>

<body>
	<?php include('navbar.php'); ?>
	<div class='container'>
		<div id='searchlist' name='searchlist' style='margin-top: 10px' class='form-row'>
			<div class='form-group col-md-2'>
				<select class='form-control' id='building'>
					<option>請選擇教學樓</option>
				</select>
			</div>
			<div class='form-group col-md-2'>
				<select class='form-control' id='classroom'>
					<option>請選擇教室</option>
				</select>
			<br>
			</div>
		</div>
		<div id='calendar'>

		</div>
	</div>
</body>

</html>