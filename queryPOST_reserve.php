<?php
$reg_date = $reg_building = $reg_username = $reg_classroom = $reg_time_start = $reg_time_end = null;
$reg_date_err = $reg_building_err = $reg_username_err = $reg_classroom_err = $reg_time_start_err = $reg_time_end_err = null;
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
;
date_default_timezone_set("Asia/Shanghai");
require_once 'config.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
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
        $reg_username_err = '沒登入';
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
        $stime = trim($_POST['reg_time_start']);
        $reg_time_start = date('Y-m-d H:i:s', strtotime("$reg_date $stime"));
    }
    if (empty(trim($_POST["reg_time_end"]))) {
        $reg_time_end_err = '請輸入終止';
    } else {
        $etime = trim($_POST['reg_time_end']);
        $reg_time_end = date('Y-m-d H:i:s', strtotime("$reg_date $etime"));
    }
    // Check input errors before inserting in database
    if (empty($reg_time_start_err) && empty($reg_time_end_err) && empty($reg_date_err) && empty($reg_username_err) && empty($reg_building_err) && empty($reg_classroom_err)) {
        // Prepare an insert statement

        $sql = "INSERT INTO `willyschool`.`reserveRecord` (`id`, `start`, `end`, `userID`, `buildingID`, `classroomID`, `timestamp`) VALUES (NULL, :reg_time_start, :reg_time_end, :reg_username, :reg_building, :reg_classroom, NULL);";
        if ($stmt = $pdo->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(':reg_time_start', $reg_time_start, PDO::PARAM_STR);
            $stmt->bindParam(':reg_time_end', $reg_time_end, PDO::PARAM_STR);
            $stmt->bindParam(':reg_username', $reg_username, PDO::PARAM_STR);
            $stmt->bindParam(':reg_building', $reg_building, PDO::PARAM_STR);
            $stmt->bindParam(':reg_classroom', $reg_classroom, PDO::PARAM_STR);

            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                echo "<script language='javascript'>
                    alert('預借成功');
                    window.open('/record.php', '_self')
                    </script>";
            } else {
                echo '<script language="javascript">';
                echo 'alert("錯誤![註冊-指令錯誤102]");';
                echo '</script>';
            }
        } else {
            echo 'error';
        }

    } else {
        echo '<script language="javascript">';
        echo 'alert( "錯誤![註冊-指令錯誤102]' . $reg_time_start_err . ' & ' . $reg_time_end_err . ' & ' . $reg_date_err . ' & ' . $reg_username_err . ' & ' . $reg_building_err . ' & ' . $reg_classroom_err . '" );';
        echo '</script>';
    }
}
