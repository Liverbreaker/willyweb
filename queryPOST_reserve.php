<?php
$reg_date = $reg_building = $reg_classroom = $reg_username = $reg_time_start = $reg_time_end = $reg_semester = $reg_semester_week = null;
$reg_date_err = $reg_building_err = $reg_classroom_err = $reg_username_err = $reg_time_start_err = $reg_time_end_err = $reg_semester_err = $reg_semester_week_err = null;
if (session_status() == PHP_SESSION_NONE) {
    session_start();
};
if(!isset($_SESSION['username'])){
	header("location: redirect.php?to=0");
	exit();
}
date_default_timezone_set("Asia/Shanghai");
require_once '/conf/config.php';

function dateRange($begin, $end, $interval = null)
{
    $begin = date_create($begin);
    $end = date_create($end);
    // Because DatePeriod does not include the last date specified.
    $end = $end->modify('+1 day');
    $interval = new DateInterval($interval ? $interval : 'P1D');
    return iterator_to_array(new DatePeriod($begin, $interval, $end));
}

function dateFilter(array $daysOfTheWeek)
{
    return function ($date) use ($daysOfTheWeek) {
        return in_array($date->format('l'), $daysOfTheWeek);
    };
}

function display($date)
{
    echo $date->format("D Y-m-d") . "<br>";
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // check all post params
    if (true) {
        if (empty(trim($_POST["reg_date"]))) {
            $reg_date_err = "請輸入日期";
        } else {
            $reg_date = trim($_POST["reg_date"]);
        }
        if (empty(trim($_POST['reg_building']))) {
            $reg_building_err = "請輸入大樓";
        } else {
            $reg_building = trim($_POST['reg_building']);
        }
        if (empty(trim($_SESSION["username"]))) {
            $reg_username_err = '未登入';
        } else {
            $reg_username = trim($_SESSION['username']);
        }
        if (empty(trim($_POST["reg_classroom"]))) {
            $reg_classroom_err = '請輸入教室';
        } else {
            $reg_classroom = trim($_POST['reg_classroom']);
        }
        if (empty(trim($_POST["reg_time_start"]))) {
            $reg_time_start_err = '請輸入起始';
        } else {
            $stime = explode("_", trim($_POST['reg_time_start']))[0];
        }
        if (empty(trim($_POST["reg_time_end"]))) {
            $reg_time_end_err = '請輸入終止';
        } else {
            $etime = explode("_", trim($_POST['reg_time_end']))[1];
        }
        if ($_POST['reserve_type'] == 'semester') {
            if (empty(trim($_POST["reg_semester"]))) {
                $reg_semester_err = '請輸入學期';
            } else {
                $reg_semester = explode("_", trim($_POST['reg_semester']));
            }
            if (empty($_POST["reg_semester_week"])) {
                $reg_semester_week_err = '請輸入星期';
            } else {
                $reg_semester_week = $_POST['reg_semester_week'];
            }
        }
    }

    // Check input errors before inserting in database
    if (empty($reg_time_start_err) && empty($reg_time_end_err) &&
        empty($reg_date_err) && empty($reg_username_err) &&
        empty($reg_building_err) && empty($reg_classroom_err) // reg is all set
    ) {
        $stime0 = intval(explode(":", $stime)[0]);
        $stime1 = intval(explode(":", $stime)[1]);
        $etime0 = intval(explode(":", $etime)[0]);
        $etime1 = intval(explode(":", $etime)[1]);
        if ($_POST['reserve_type'] == 'normal') {
            $sql = "INSERT INTO `willyschool`.`reserve` (`id`, `start`, `end`, `userID`, `buildingID`, `classroomID`, `timestamp`) VALUES (NULL, :reg_datetime_start, :reg_datetime_end, :reg_username, :reg_building, :reg_classroom, NULL);";
            $stmt = $pdo->prepare($sql);
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(':reg_datetime_start', date_time_set(date_create($reg_date), $stime0, $stime1)->format('Y-m-d H:i:s'), PDO::PARAM_STR);
            $stmt->bindParam(':reg_datetime_end', date_time_set(date_create($reg_date), $etime0, $etime1)->format('Y-m-d H:i:s'), PDO::PARAM_STR);
            $stmt->bindParam(':reg_username', $reg_username, PDO::PARAM_STR);
            $stmt->bindParam(':reg_building', $reg_building, PDO::PARAM_STR);
            $stmt->bindParam(':reg_classroom', $reg_classroom, PDO::PARAM_STR);
            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                // $stmt->debugDumpParams();
                echo "<script language='javascript'>
                    alert('normal 預借成功');
                    window.open('/record.php', '_self')
                    </script>";
            } else {
                // $stmt->debugDumpParams();
                echo '<script language="javascript">';
                echo 'alert("錯誤![execute error, reserve type normal]");';
                echo '</script>';
            }
        } else if ($_POST['reserve_type'] == 'semester') {
            if (empty($reg_semester_err) && empty($reg_semester_week_err)) {
                $dates = dateRange($reg_semester[1], $reg_semester[2]);
                $alldays = array_filter($dates, dateFilter($reg_semester_week));
                $sql = "INSERT INTO `willyschool`.`reserve` (`id`, `start`, `end`, `userID`, `buildingID`, `classroomID`, `timestamp`) VALUES (NULL, :reg_datetime_start, :reg_datetime_end, :reg_username, :reg_building, :reg_classroom, CURRENT_TIMESTAMP);";
                $stmt = $pdo->prepare($sql);
                // Bind variables to the prepared statement as parameters
                $stmt->bindParam(':reg_username', $reg_username, PDO::PARAM_STR);
                $stmt->bindParam(':reg_building', $reg_building, PDO::PARAM_STR);
                $stmt->bindParam(':reg_classroom', $reg_classroom, PDO::PARAM_STR);
                // Attempt to execute the prepared statement
                try {
                    foreach ($alldays as $key => $val) {
                        $st = date_time_set($val, $stime0, $stime1)->format('Y-m-d H:i:s'); //date_create($val)
                        // echo $st;
                        $et = date_time_set($val, $etime0, $etime1)->format('Y-m-d H:i:s');
                        // echo $et;
                        $stmt->bindParam(':reg_datetime_start', $st, PDO::PARAM_STR);
                        $stmt->bindParam(':reg_datetime_end', $et, PDO::PARAM_STR);
                        $stmt->execute();
                        // echo date_time_set($val, $stime0, $stime1)->format('Y-m-d H:i:s'); // start datetime
                    };
                    echo '<script language="javascript">';
                    echo 'alert("預借成功!");';
                    echo "window.open('/record.php', '_self')";
                    echo '</script>';
                } catch (PDOException $e) {
                    echo '<script language="javascript">';
                    echo 'alert("execution error, type semester!");';
                    echo '</script>';
                    echo "Error: " . $e->getMessage();
                }
            } else {
                echo '<script language="javascript">';
                echo 'alert("錯誤![reserve type semester, reg data error]'
                    . '\n semester error: ' . $reg_semester_err . '\n week error: ' . $reg_semester_week_err .
                    '");';
                echo '</script>';
            }
        } else {
            echo '<script language="javascript">';
            echo 'alert("錯誤![reserve type error]");';
            echo '</script>';
        }
    } else {
        echo '<script language="javascript">';
        echo 'alert( "錯誤![reg data error]' .
            $_POST['reserve_type'] . '\n' .
            'reg date: ' . $reg_date_err . '\n' .
            'reg name: ' . $reg_username_err . '\n' .
            'reg bui: ' . $reg_building_err . '\n' .
            'reg cla: ' . $reg_classroom_err . '\n' .
            'reg ts: ' . $reg_time_start_err . '\n' .
            'reg te: ' . $reg_time_end_err . '\n' .
            'reg sem: ' . $reg_semester_err . '\n' .
            'reg sem wk: ' . $reg_semester_week_err . '\n' .
            '" );';
        echo '</script>';
    }
}
