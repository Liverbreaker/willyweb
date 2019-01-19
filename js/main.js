// for all javascript;
$(document).ready(function () {
	'use strict';
	// $(selector).get(url,data,success(response,status,xhr),dataType)
	function getBuildings(){
		$.get("./queryGet.php", {get: 'buildings'},
		function(response){
			if (response){ $('#building').append(response);}
		});
	};
	getBuildings();

	// get classroom list where building set
	function getClassroom() {
		var building = $('#building option:selected').attr('to');
		$.get('./queryGet.php', { get: 'classroom', building: building },
		function (result) {
			if (result) {
				$('#classroom').append(result);
			}
		});
	};

	// when building option changed, get classroom list
	$('#building').change(function () {
		$('#classroom').empty();
		$('#classroom').append("<option>請選擇教室</option>");
		getClassroom();
	});

	// clean calendar data
	function clearCal(){
		$('.cal').fullCalendar('removeEvents');
	}
	// add calendar with classroom reserve record to id=calendar (index.php)
	if ( $('#calendar-init').length ) {
		$('#calendar-init').fullCalendar({
			schedulerLicenseKey: 'GPL-My-Project-Is-Open-Source',
			defaultView: 'agendaWeek',
			// groupByResource: true,
			editable: false,
			height: "auto",
			header: {
			  left: 'prev, today, next',
			  center: 'title',
			  right: 'agendaDay, agendaWeek, list'
			},
			views: {
			  agendaFourDay: {
				type: 'agenda',
				duration: { days: 7 }
			  }
			},
		});
	}

	// if on my record page, set calendar
	if ( $('#rtable').length ) {
		$('#rtable').append("<div id='calendar-me' class='cal'></div>");
		var $myevent = getRecordEvent(undefined, undefined, true);
		$('#calendar-me').fullCalendar({
			schedulerLicenseKey: 'GPL-My-Project-Is-Open-Source',
			defaultView: 'agendaWeek',
			// groupByResource: true,
			editable: true,
			navLinks: true, // can click day/week names to navigate views
			nowIndicator: true, // indicates now
			
			header: {
			  left: 'prev,today,next',
			  center: 'title',
			  right: 'agendaWeek,agendaDay,listWeek'
			},
			views: {
			  agendaFourDay: {
				type: 'agenda',
				duration: { days: 7 }
			  }
			},
			eventClick: function(calEvent, jsEvent, view) {
				$('#EventModal').show();
				$('.modal-header h2').text("詳細資料");
				$('.modal-body').text("");
				$('.modal-body').append("<p>教室代碼: "+calEvent.title+"</p>");
				var ds = new Date(calEvent.start);
				var de = new Date(calEvent.end);
				$('.modal-body').append("<p>預借　從: "+ds.toLocaleString()+"</p>");
				$('.modal-body').append("<p>預借　到: "+de.toLocaleString()+"</p>");
				$('.modal-body').append("<p>id　　　: "+calEvent.id+"</p>");
				$('.modal-footer h3').html("<button name='deleteReserve' to='"+calEvent.id+"'>delete</button>");
				// alert('Coordinates: ' + jsEvent.pageX + ',' + jsEvent.pageY);
				// alert('View: ' + view.name);
				$(this).css('border-color', 'red');
			}
		});
		$('#calendar-me').fullCalendar(
			'addEventSource', $myevent
		);
	}
	
	// when classroom selection changed, get all reserve record
	$('#classroom').change(function() {
		var $building = $('#building option:selected').attr('to'),
			$classroom = $('#classroom option:selected').attr('to'),
			$bc = $building + $classroom,
			$myevent = getRecordEvent(building = $building, classroom = $classroom);
		console.log($bc);
		clearCal(); // clear calendar
		$('#calendar-init').fullCalendar(
			'addEventSource', $myevent
		);
	});
	
	// get record function
	function getRecordEvent(building, classroom, WithUserID){
		var building = building || undefined,
			classroom = classroom || undefined,
			WithUserID = WithUserID || true; // false
		return $.getJSON({ // edited
			url: '/queryGet.php',
			data: {
				get: 'record',
				building: building,
				classroom: classroom,
				WithUserID: WithUserID
			}
		}).then(function(data){
			return data.responseJSON
		});
	}

	// when close (x) clicked, close modal
	$(document).on('click', '#closeModal', function() {
		$('#EventModal').hide();
	});
	// $(window).on('click', '#EventModal', function(event) {
	// 	if (event.target == $('#EventModal')) {
	// 		$('#EventModal').hide();
	// 	}
	// });

	// get semester data function
	function init_sem(){
		$.ajax({
			type: 'GET',
			url: 'queryGet_semester.php',
			success: function(result){
				$('#semester').append(result);
			}
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

	$('input[type=radio][name=reserve_type]').change(function () {
		if (this.value == 'normal') {
			$('#regType_normal').show();
			$('#regType_semester').hide();
		} else if (this.value == 'semester') {
			$('#regType_normal').hide();
			$('#regType_semester').show();
		}
	});

	$('button[name=deleteReserve]').click(function () {
		console.log('button pressed');
		// var $id = this.getAttribute('target'),
		// 	$sql = "DELETE FROM `record` WHERE `record`.`id` = " + parseInt($id);
		// $.ajax({
		// 	type: 'POST',
		// 	url: 'queryPOST.php',
		// 	data: {
		// 		var1: $id,
		// 		sql: $sql
		// 	},
		// 	success: function () {
		// 		alert('刪除紀錄成功');
		// 		location.reload();
		// 	},
		// 	error: function () {
		// 		alert('指令失敗');
		// 	}
		// });
	});


	$('button[name=deleteUser]').click(function () {
		var $id = this.getAttribute('target');
		var $sql = "DELETE FROM `users` WHERE `users`.`username` = " + parseInt($id);
		$.ajax({
			type: 'POST',
			url: 'queryPOST.php',
			data: {
				var1: $id,
				sql: $sql
			},
			success: function () {
				alert('刪除帳號成功');
				location.reload();
			},
			error: function () {
				alert('指令失敗');
			}
		});
	});
	$('button[name=deleteSemester]').click(function () {
		var $id = this.getAttribute('target');
		var $sql = "DELETE FROM `semester` WHERE `semester`.`id` = " + parseInt($id);
		$.ajax({
			type: 'POST',
			url: 'queryPOST.php',
			data: {
				var1: $id,
				sql: $sql
			},
			success: function () {
				alert('刪除學期區間成功');
				location.reload();
			},
			error: function () {
				alert('指令失敗');
			}
		});
	});
	$('input[type=checkbox][name=isFix]').change(function(){
		var $id = $(this).attr('to');
		if ($(this).prop('checked')) {
			$("#permission_"+$id).prop("disabled", false);
			$("#saveUser_"+$id).show();
		} else {
			$("#permission_"+$id).prop("disabled", true);
			$("#saveUser_"+$id).hide();
		}
	});
	$('button[name=saveUser]').click(function () {
		var $id = this.getAttribute('target'),
		$perm = $("#permission_"+$id).val();
		var $sql = "UPDATE `users` SET `permission` = '" +$perm+ "' WHERE `users`.`username` = " + parseInt($id);
		$.ajax({
			type: 'POST',
			url: 'queryPOST.php',
			data: {
				sql: $sql
			},
			success: function () {
				alert('更新帳號成功');
				location.reload();
			},
			error: function () {
				alert('指令失敗');
			}
		});
	});
});