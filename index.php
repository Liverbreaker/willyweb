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
<<<<<<< HEAD
<<<<<<< HEAD
	<link rel='stylesheet' href='/css/cal/fullcalendar.css' />
	<link rel='stylesheet' href='/css/cal/scheduler.css' />
	
	<script src="/js/jquery.min.js"></script>
	<script src="/js/bootstrap.min.js"></script>
	<script src='/js/main.js'></script>
	<script src='/js/cal/moment.min.js'></script>
	<script src='/js/cal/fullcalendar.js'></script>
	<script src='/js/cal/scheduler.js'></script>
=======
	<script src="/js/jquery.min.js"></script>
	<script src="/js/bootstrap.min.js"></script>
	<script src='/js/main.js'></script>
>>>>>>> parent of 7b4d47a... 0.1
=======
	<script src="/js/jquery.min.js"></script>
	<script src="/js/bootstrap.min.js"></script>
	<script src='/js/main.js'></script>
>>>>>>> parent of 7b4d47a... 0.1

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
<<<<<<< HEAD
<<<<<<< HEAD
			<br>
			</div>
		</div>
		<div id='calendar'>

		</div>
=======
=======
>>>>>>> parent of 7b4d47a... 0.1
			</div>
			<div class='form-group col-md-1'>請選查詢期間:</div>
			<div class='input-group col-md-5 input-date range'>
				<input type='date' class='form-control' id='time_start'>
				<div class='input-group-addon'>到</div>
				<input type='date' class='form-control' id='time_end'>
			</div>
			<div class='form-group'>
				<button class='btn btn-success' id='search'>查詢</button>
			</div>
		</div>
		<div name='recordList'>
			<table class='table table-hover'>
				<thead>
					<th>課時起</th>
					<th>課時迄</th>
					<th>借用教師</th>
					<th>借用大樓</th>
					<th>借用教室</th>
				</thead>
				<tbody id='getRecord'></tbody>
			</table>
		</div>

<<<<<<< HEAD
>>>>>>> parent of 7b4d47a... 0.1
=======
>>>>>>> parent of 7b4d47a... 0.1
	</div>
</body>

</html>