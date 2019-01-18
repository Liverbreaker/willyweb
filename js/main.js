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
<<<<<<< HEAD
<<<<<<< HEAD

	$('#calendar').fullCalendar({
		schedulerLicenseKey: 'GPL-My-Project-Is-Open-Source',
		defaultView: 'agendaFourDay',
    groupByResource: true,
    header: {
      left: 'prev,next',
      center: 'title',
      right: 'agendaDay,agendaWeek'
    },
    views: {
      agendaFourDay: {
        type: 'agenda',
        duration: { days: 7 }
      }
    },
    resources: [
      { id: 'a', title: 'Room A' }
    ],
    events:[
		{
			id: '1',
      		resourceId: 'a',
			title: 'Meeting',
			start: '2019-01-20T10:30:00',
			end: '2019-01-20T12:30:00',
		  },
	  ],
		
		
	});
=======
>>>>>>> parent of 7b4d47a... 0.1
=======
>>>>>>> parent of 7b4d47a... 0.1
	
	function getClassroom() {
		var building = $('#building option:selected').val();
		$.ajax({
			type: 'GET',
			url: 'queryGet.php',
			data: {
				get: 'classroom',
				building: building
			},
			success: function (result) {
				if (result) {
					$('#classroom').append(result);
				}
			},
			error: function () {}
		});
	};
	getClassroom();
	$('#building').change(function () {
		$('#classroom').empty();
		$('#classroom').append("<option>請選擇教室</option>");
		getClassroom();
	});
	$('#search').click(function () {
		var $building = $('#building').val(),
			$classroom = $('#classroom').val(),
			$time_start = $('#time_start').val(),
			$time_end = $('#time_end').val();
		var $sql = "SELECT * FROM `record` WHERE `大樓` = '" + $building + "' and `教室代號` = '" + $classroom + "' and `課時起` between '" + $time_start + "' and '" + $time_end + "';"
		$.ajax({
			type: 'POST',
			url: 'queryGET_record.php',
			data: {
				sql: $sql
			},
			success: function (result) {
				if (result) {
					console.log($sql);
					$('#getRecord').empty();
					$('#getRecord').append(result);
				}
			},
			error: function () {
				alert('查詢失敗');
			}
		});
	});
	
	$.ajax({
		type: 'GET',
		url: 'queryGet_semester.php',
		success: function(result){
			$('#semester').append(result);
		}
	});

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
	$('button[name=delete]').click(function () {
		var $id = this.getAttribute('target');
		var $sql = "DELETE FROM `record` WHERE `record`.`id` = " + parseInt($id);
		$.ajax({
			type: 'POST',
			url: 'queryPOST.php',
			data: {
				var1: $id,
				sql: $sql
			},
			success: function () {
				alert('刪除紀錄成功');
				location.reload();
			},
			error: function () {
				alert('指令失敗');
			}
		});
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