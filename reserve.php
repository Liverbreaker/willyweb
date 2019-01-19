<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once('/conf/config.php');
?>
<html>

<head>
	<meta charset='UTF-8'>
	<title>預借教室</title>
	<link rel="stylesheet" href="/css/bootstrap.min.css">
	<link rel='stylesheet' href='/css/font-awesome.min.css'>
	<link rel='stylesheet' href='/css/navbar.css'>
	<script src="/js/jquery.min.js"></script>
	<script src="/js/bootstrap.min.js"></script>
	<script src='/js/main.js'></script>
</head>

<body>
	<?php include 'navbar.php';?>
	<div class='container'>
		<form method="post" action="queryPOST_reserve.php">
			<fieldset class="form-group">
				<legend class="scheduler-border">借用期間</legend>
				<div class="row">
					<legend class="col-form-label col-sm-2 pt-0">類型</legend>
					<div class="col-sm-10">
						<div class="form-check">
							<input class="form-check-input" type="radio" name="reserve_type" value="normal" checked>
							<label class="form-check-label" for="gridRadios1">
								平時預借
							</label>
						</div>
						<div class="form-check">
							<input class="form-check-input" type="radio" name="reserve_type" value="semester">
							<label class="form-check-label" for="gridRadios2">
								學期預借
							</label>
						</div>
					</div>
				</div>
				<div class="form-group row regType" id='regType_normal'>
					<legend for="reg_date" class="col-form-label col-sm-2 pt-0">預約日期(Date)</legend>
					<div class="col-sm-4"><input type="date" class="form-control" name="reg_date" id='reg_date'></div>
				</div>
				<div class="form-group row regType" id='regType_semester' style='display: none'>
					<label for="inputSemester" class="col-sm-2 col-form-label">學期:</label>
					<div class="col-sm-2"><select class='form-control' id='semester' target="semester"></select></div>
					<label for="inputWeek" class="col-sm-2 col-form-label">星期:</label>
					<div class="col-sm-1">
						<select class='form-control' id='day' target="day">
							<option>一</option>
							<option>二</option>
							<option>三</option>
							<option>四</option>
							<option>五</option>
							<option>六</option>
							<option>日</option>
						</select>
					</div>
				</div>
			</fieldset>
			<fieldset class="scheduler-border">
				<legend class="scheduler-border">借用明細</legend>
				<ul>
					<div id="reserve" class="form-row">
						<div class='col'>
							<label for="reg_building">大樓(Building)</label>
							<select class='form-control' id='building' name='reg_building'>
							<option>請選擇教學樓</option>
							</select>
						</div>
						<div class="col">
							<label for="reg_classroom">教室(Classroom)</label>
							<select class='form-control' id='classroom' name='reg_classroom'>
							<option>請選擇教室</option>
							</select>
						</div>
						<div class="col" style='display:none;'>
							<label for="reg_username">教師編號(Id)</label>
							<input type="text" class="form-control" name="reg_username" value='<?php echo $_SESSION[' username']; ?>'>
						</div>
					</div>
				</ul>
				<ul>
					<div id="" class="form-row">
						<div class="col">
							<label for="reg_time_start">預約時段(Time)起</label>
							<input type="time" class="form-control" name="reg_time_start" value="<?php $date = date(" H:i",
							 strtotime($row['reg_time_start']));?>">
						</div>
						<div class="col">
							<label for="reg_time_end">預約時段(Time)止</label>
							<input type="time" class="form-control" name="reg_time_end" value="<?php $date = date(" H:i",
							 strtotime($row['reg_time_end']));?>">
						</div>
					</div>
				</ul>
				<input type="submit" class='btn btn-success' value="提交">
			</fieldset>
		</form>
	</div>
</body>

</html>