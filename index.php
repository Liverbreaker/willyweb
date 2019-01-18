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
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm"
	 crossorigin="anonymous">
	<link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css'>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
	 crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
	 crossorigin="anonymous"></script>
	<link rel='stylesheet' href='css/navbar.css'>
	<script type='text/javascript' src='js/main.js'></script>

</head>

<body>
	<?php include('navbar.php'); ?>
	<div class='container'>
		<div name='searchlist' style='margin-top: 10px' class='form-row'>
			<div class='form-group col-md-2'>
				<select class='form-control' id='building'>
					<option>請選擇教學樓</option>
					<?php include('queryGet_building.php'); ?>
				</select>
			</div>
			<div class='form-group col-md-2'>
				<select class='form-control' id='classroom'>
					<option>請選擇教室</option>
				</select>
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

	</div>
</body>

</html>