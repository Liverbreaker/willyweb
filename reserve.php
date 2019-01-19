<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once('/conf/config.php');
if(!isset($_SESSION['username'])){
	header("location: redirect.php?to=0");
	exit();
}
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
					<legend class="col-form-label col-sm-1 pt-0">類型</legend>
					<div class="col-sm-10">
						<div class="form-check row">
							<input class="form-check-input" type="radio" name="reserve_type" value="normal" checked>
							<label class="form-check-label col-sm-2" for="gridRadios1">
								平時預借
							</label>
							<div class="form-group regType" id='regType_normal'>
								<label for="reg_date" class="col-form-label col-sm-1">日期</label>
								<div class="col-sm-3"><input type="date" class="form-control" name="reg_date" id='reg_date'></div>
							</div>
						</div>
						<div class="form-check row">
							<input class="form-check-input" type="radio" name="reserve_type" value="semester">
							<label class="form-check-label col-sm-2" for="gridRadios2">
								學期預借
							</label>
							<div class="form-group row regType" id='regType_semester' style='display: none'>
								<label for="inputSemester" class="col-form-label col-sm-1">學期:</label>
								<div class="col-sm-2">
									<select class='form-control' id='semester' target="semester" name='reg_semester'></select>
									</div>
								<label for="inputWeek" class="col-sm-2 col-form-label">星期:</label>
								<div class="col-sm-5">
									<input class='form-check-input' type='checkbox' name='reg_semester_week[]' value='Monday' id='chkbx1'>
									<label class='form-check-label' for='chkbx1'>週一</label>
									<input class='form-check-input' type='checkbox' name='reg_semester_week[]' value='Tuesday' id='chkbx2'>
									<label class='form-check-label' for='chkbx2'>週二</label>
									<input class='form-check-input' type='checkbox' name='reg_semester_week[]' value='Wednesday' id='chkbx3'>
									<label class='form-check-label' for='chkbx3'>週三</label>
									<input class='form-check-input' type='checkbox' name='reg_semester_week[]' value='Thursday' id='chkbx4'>
									<label class='form-check-label' for='chkbx4'>週四</label>
									<input class='form-check-input' type='checkbox' name='reg_semester_week[]' value='Friday' id='chkbx5'>
									<label class='form-check-label' for='chkbx5'>週五</label>
									<input class='form-check-input' type='checkbox' name='reg_semester_week[]' value='Saturday' id='chkbx6'>
									<label class='form-check-label' for='chkbx6'>週六</label>
									<input class='form-check-input' type='checkbox' name='reg_semester_week[]' value='Sunday' id='chkbx7'>
									<label class='form-check-label' for='chkbx7'>週日</label>
								</div>
							</div>
						</div>
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
							<input type="text" class="form-control" name="reg_username" value='<?php echo $_SESSION['username']; ?>'>
						</div>
					</div>
				</ul>
				<ul>
					<div id="" class="form-row">
						<div class="col">
							<label for="reg_time_start">預約時段(Time)起</label>
							<select class='form-control' name='reg_time_start'>
								<option value='07:10_08:00'>D0 07:10 - 08:00</option>
								<option value='08:10_09:00' selected>D1 08:10 - 09:00</option>
								<option value='09:10_10:00'>D2 09:10 - 10:00</option>
								<option value='10:10_11:00'>D3 10:10 - 11:00</option>
								<option value='11:10_12:00'>D4 11:10 - 12:00</option>
								<option value='12:00_12:40'>D? 12:00 - 12:40</option>
								<option value='12:40_13:30'>DN 12:40 - 13:30</option>
								<option value='13:40_14:30'>D5 13:40 - 14:30</option>
								<option value='14:40_15:30'>D6 14:40 - 15:30</option>
								<option value='15:40_16:30'>D7 15:40 - 16:30</option>
								<option value='16:40_17:30'>D8 16:40 - 17:30</option>
								<option value='17:40_18:30'>E0 17:40 - 18:30</option>
								<option value='18:40_19:30'>E1 18:40 - 19:30</option>
								<option value='19:35_20:20'>E2 19:35 - 20:20</option>
								<option value='20:30_21:20'>E3 20:30 - 21:20</option>
								<option value='21:25_22:10'>E4 21:25 - 22:10</option>
							</select>
						</div>
						<div class="col">
							<label for="reg_time_end">預約時段(Time)止</label>
							<select class='form-control' name='reg_time_end'>
								<option value='07:10_08:00'>D0 07:10 - 08:00</option>
								<option value='08:10_09:00'>D1 08:10 - 09:00</option>
								<option value='09:10_10:00' selected>D2 09:10 - 10:00</option>
								<option value='10:10_11:00'>D3 10:10 - 11:00</option>
								<option value='11:10_12:00'>D4 11:10 - 12:00</option>
								<option value='12:00_12:40'>D? 12:00 - 12:40</option>
								<option value='12:40_13:30'>DN 12:40 - 13:30</option>
								<option value='13:40_14:30'>D5 13:40 - 14:30</option>
								<option value='14:40_15:30'>D6 14:40 - 15:30</option>
								<option value='15:40_16:30'>D7 15:40 - 16:30</option>
								<option value='16:40_17:30'>D8 16:40 - 17:30</option>
								<option value='17:40_18:30'>E0 17:40 - 18:30</option>
								<option value='18:40_19:30'>E1 18:40 - 19:30</option>
								<option value='19:35_20:20'>E2 19:35 - 20:20</option>
								<option value='20:30_21:20'>E3 20:30 - 21:20</option>
								<option value='21:25_22:10'>E4 21:25 - 22:10</option>
							</select>
						</div>
					</div>
				</ul>
				<input type="submit" class='btn btn-success' value="提交">
			</fieldset>
		</form>
	</div>
</body>

</html>