// for all javascript;
$(document).ready(function () {
	'use strict';
	// $(selector).get(url,data,success(response,status,xhr),dataType)
	function getBuildings() {
		$.get("./queryGet.php?get=buildings",
			function (response) {
				$('#building').append(response);
			});
	};

	if ($('#building').length) {
		getBuildings();
	}

	// get classroom list where building set
	function getClassroom() {
		var building = $('#building option:selected').attr('value');
		$.get('./queryGet.php?get=classroom', {
				building: building
			},
			function (result) {
				$('#classroom').append(result);
			});
	};

	// when building option changed, get classroom list
	$('#building').change(function () {
		$('#classroom').empty();
		$('#classroom').append("<option>請選擇教室</option>");
		getClassroom();
	});

	// clean calendar data

	function clearCal() {
		if ($('.cal').length) {
			$('.cal').fullCalendar('removeEvents');
		}
	}

	// add calendar with classroom reserve record to id=calendar (index.php)
	if ($('#calendar-init').length) {
		$('#calendar-init').fullCalendar({
			schedulerLicenseKey: 'GPL-My-Project-Is-Open-Source',
			defaultView: 'agendaWeek',
			// groupByResource: true,
			editable: false,
			navLinks: true,
			nowIndicator: true, // indicates now
			height: "auto",
			header: {
				left: 'prev,today,next',
				center: 'title',
				right: 'agendaDay,agendaWeek,listWeek'
			},
			views: {
				agendaFourDay: {
					type: 'agenda',
					duration: {
						days: 7
					}
				}
			},
		});
	}

	// if on my record page, set calendar
	if ($('#rtable').length) {
		$('#rtable').append("<div id='calendar-me' class='cal'></div>");
		$('#calendar-me').fullCalendar({
			schedulerLicenseKey: 'GPL-My-Project-Is-Open-Source',
			defaultView: 'agendaWeek',
			// groupByResource: true,
			editable: true,
			navLinks: true, // can click day/week names to navigate views
			nowIndicator: true, // indicates now
			height: 'auto',
			header: {
				left: 'prev,today,next',
				center: 'title',
				right: 'agendaWeek,agendaDay,listWeek'
			},
			views: {
				agendaFourDay: {
					type: 'agenda',
					duration: {
						days: 7
					}
				}
			},
			eventClick: function (calEvent, jsEvent, view) {
				$('#EventModal').show();
				$('.modal-header h2').text("詳細資料");
				$('.modal-body').text("");
				$('.modal-body').append("<p>教室代碼: " + calEvent.title + "</p>");
				var ds = new Date(calEvent.start).toUTCString();
				var de = new Date(calEvent.end).toUTCString();
				$('.modal-body').append("<p>預借　從: " + ds + "</p>");
				$('.modal-body').append("<p>預借　到: " + de + "</p>");
				$('.modal-body').append("<p>id　　　: " + calEvent.id + "</p>");
				$('.modal-footer h3').html("<button name='deleteReserve' to='" + calEvent.id + "' class='btn btn-danger'>delete</button>");
				// alert('Coordinates: ' + jsEvent.pageX + ',' + jsEvent.pageY);
				// alert('View: ' + view.name);
				$(this).css('border-color', 'red');
			}
		});
		var $myevent = getRecordEvent(undefined, undefined, true);
		clearCal(); // clear calendar
		$('#calendar-me').fullCalendar(
			'addEventSource', JSON.parse($myevent)
		);
	}

	// when classroom selection changed, get all reserve record
	$('#classroom').change(function () {
		var me = window.location.pathname;
		if ((me == '/index.php') | (me == '/')) {
			// console.log(me);
			var $building = $('#building option:selected').attr('value'),
				$classroom = $('#classroom option:selected').attr('value'),
				$myevent = getRecordEvent($building, $classroom);
			// console.log($myevent);
			clearCal(); // clear calendar
			$('#calendar-init').fullCalendar(
				'addEventSource', JSON.parse($myevent)
			);
		} else if (me == '/reserve.php') {
			// console.log(me);
		}
	});

	// get record function
	function getRecordEvent(building, classroom, WithUserID //, start, end
	) {
		var building = building || undefined,
			classroom = classroom || undefined,
			WithUserID = WithUserID || false;
		// start = start || undefined,
		// end = end || undefined;
		return $.ajax({ // edited
			type: 'GET',
			url: '/queryGet.php',
			data: {
				get: 'record',
				building: building,
				classroom: classroom,
				WithUserID: WithUserID,
				// start: start,
				// end: end,
			},
			async: false,
		}).responseText;
	}

	// when close (x) clicked, close modal
	$(document).on('click', '#closeModal', function () {
		var $me = window.location.pathname;
		if ($me == '/record.php') {
			$('#EventModal').hide();
		} else if ($me == '/semestertool.php') {
			$('#SemesterModal').hide();
		}
	});
	// delete reservedrecord
	$(document).on('click', 'button[name=deleteReserve]', function () {
		// console.log('button pressed');
		var $id = this.getAttribute('to'),
			$sql = "DELETE FROM `willyschool`.`reserve` WHERE `reserve`.`id` = :var1";
		if (confirm("是否確定刪除預約紀錄?")) {
			$.ajax({
				type: 'POST',
				url: 'queryPOST.php',
				data: {
					var1: $id,
					// var2: undefined,
					// var3: undefined,
					// var4: undefined,
					sql: $sql
				},
				success: function (result) {
					alert('刪除紀錄成功\n');
					location.reload();
					console.log($sql + '\n' + result);
				},
				error: function () {
					alert('指令失敗');
				}
			});
		} else {
			alert('已取消');
		}
	});

	// get semester data function
	if ($('#semester').length) {
		$.get('queryGet.php?get=semester', function (result) {
			$('#semester').append(result);
		});
	}

	// when reserving, set default date
	function initializeDate() {
		var today = new Date();
		var nextmonth = new Date(today.getFullYear(), today.getMonth() + 1, today.getDate());
		var yyyy = today.getFullYear().toString();
		var yyyy2 = nextmonth.getFullYear().toString();
		var mm = (today.getMonth() + 1).toString();
		var mm2 = (nextmonth.getMonth() + 1).toString();
		var dd = today.getDate().toString();
		var dd2 = nextmonth.getDate().toString();
		$('#reg_date').val(yyyy + "-" + (mm[1] ? mm : "0" + mm[0]) + "-" + (dd[1] ? dd : "0" + dd[0]));
		$('#time_start').val(yyyy + "-" + (mm[1] ? mm : "0" + mm[0]) + "-" + (dd[1] ? dd : "0" + dd[0]));
		$('#time_end').val(yyyy2 + "-" + (mm2[1] ? mm2 : "0" + mm2[0]) + "-" + (dd2[1] ? dd2 : "0" + dd2[0]));
	};
	initializeDate();

	// when select reserve type (normal or semester), show either input bar
	$('input[type=radio][name=reserve_type]').change(function () {
		if (this.value == 'normal') {
			$('#regType_normal').show();
			$('#regType_semester').hide();
		} else if (this.value == 'semester') {
			$('#regType_normal').hide();
			$('#regType_semester').show();
		}
	});
	// when permission checkbox clicked, enable/disable permission selecting function
	$('input[type=checkbox][id^=isFix]').change(function () {
		var $id = $(this).attr('target');
		if ($(this).prop('checked')) {
			$("#permission_" + $id).prop("disabled", false);
			$("#saveUser_" + $id).show();
		} else {
			$("#permission_" + $id).prop("disabled", true);
			$("#saveUser_" + $id).hide();
		}
	});
	// when save user permission clicked, save setting
	$('button[id^=saveUser]').click(function () {
		var $id = this.getAttribute('target'),
			$username = this.getAttribute('to'),
			$perm = $("#permission_" + $username).val(),
			$sql = "UPDATE `willyschool`.`users` SET `permission` = '" + $perm + "' WHERE `users`.`id` = " + parseInt($id) + " and `users`.`username` = '" + $username + "';";
		if (confirm("請問是否要變更 '" + $username + "' 的使用者權限為: " + $perm + "?")) {
			$.ajax({
				type: 'POST',
				url: 'queryPOST.php',
				data: {
					sql: $sql
				},
				success: function () {
					alert('更新權限成功');
					location.reload();
				},
				error: function () {
					alert('指令失敗');
				}
			});
		} else {
			alert('已取消');
		}
	});
	// when delete user btn clicked, delete the user
	$('button[id^=deleteUser]').click(function () {
		var $id = this.getAttribute('target'),
			$username = this.getAttribute('to'),
			$sql = "DELETE FROM `willyschool`.`users` WHERE `users`.`id` = " + parseInt($id) + " and `users`.`username` = '" + $username + "';";
		if (confirm("請問是否要刪除 '" + $username + "' 的帳號? (將無法回復)")) {
			$.ajax({
				type: 'POST',
				url: 'queryPOST.php',
				data: {
					sql: $sql
				},
				success: function () {
					alert('刪除 `帳號` 成功');
					location.reload();
				},
				error: function () {
					alert('指令失敗');
				}
			});
		} else {
			alert('已取消');
		}
	});
	// when delete semester btn clicked, delete the semester period
	$('button[id^=deleteSemester]').click(function () {
		var $id = this.getAttribute('target'),
			$semesterName = this.getAttribute('to'),
			$sql = "DELETE FROM `willyschool`.`semester` WHERE `semester`.`id` = " + parseInt($id) + " and `semester`.`semesterName` = '" + $semesterName + "';";
		if (confirm("請問是否要刪除 '" + $semesterName + "'學期 區間紀錄? (將無法回復)")) {
			$.ajax({
				type: 'POST',
				url: 'queryPOST.php',
				data: {
					sql: $sql
				},
				success: function () {
					alert('刪除 `學期區間` 成功');
					location.reload();
				},
				error: function () {
					alert('指令失敗');
				}
			});
		} else {
			alert('已取消');
		}
	});

	$('#modal1').click(function () {
		$('#SemesterModal').show();
		$('.modal-header h2').text("增加新學期區間");
		$('.modal-header p').text("請填入以下欄位");
		$('.modal-body').text("");
		var $mybody = "<div class='container'>" +
			"<div class='row'>" +
			"<label for='startDate_semester'><b>起始日</b></label>" +
			"<input type='date' class='form-control col-md-3' id='startDate_semester' style='padding-top:0px;' required>" +
			"</div>" +
			"<div class='row'>" +
			"<label for='endDate_semester'><b>終止日</b></label>" +
			"<input type='date' class='form-control col-md-3' id='endDate_semester' style='padding-top:0px;' required>" +
			"</div>" +
			"<div class='row'>" +
			"<label for='semesterName_semester'><b>學期名</b>" +
			"<input type='text' class='form-control col-md-3' placeholder='請填入 學期名' id='semesterName_semester' required></label>" +
			"</div></div><div>" +
			"<br><p>若無教師代號請洽輔仁大學XX處 電話:<a href='#'>02-29052000</a>.</p>" +
			"<button id='submitNewSemester_semester' type='submit' class='btn btn-success'>提交</button>" +
			"</div>";
		$('.modal-body').append($mybody);
		$('.modal-footer').text("");
		var $myfooter = "";
		$('.modal-footer').append($myfooter);

	});

	$(document).on('click','#submitNewSemester_semester', function(){
		var $startDate = $('#startDate_semester').val(),
			$endDate = $('#endDate_semester').val(),
			$semesterName = $('#semesterName_semester').val();
		if ( $startDate && $endDate && $semesterName ){
			$.ajax({
				type: 'POST',
				url: '/newsemester.php',
				data: {
					startDate: $startDate,
					endDate: $endDate,
					semesterName: $semesterName
				},
				success: function (result) {
					alert('新增學期區間成功!');
					location.reload();
					console.log(result);
				},
				fail: function() {
					alert('指令錯誤[新增學期區間]!');
				}
			});
		} else {
			alert('請填妥所有欄位');
		}
	});
});