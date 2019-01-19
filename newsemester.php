<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once('/conf/config.php');
if(!isset($_SESSION['username']) || ($_SESSION['permission'] !== 'admin')){
	header("location: redirect.php?to=0");
	exit();
}
$startDate = $endDate = $semesterName = null;
$startDate_err = $endDate_err = $semesterName_err = null;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty(trim($_POST["startDate"]))) {
        $startDate_err = "&nbsp;&nbsp;&nbsp;請輸入起始日";
    } else {
        $startDate = trim($_POST['startDate']);
    }
    if (empty(trim($_POST['endDate']))) {
        $endDate_err = "&nbsp;&nbsp;&nbsp;請輸入終止日";
    }else {
        $endDate = trim($_POST['endDate']);
    }
    if (empty(trim($_POST["semesterName"]))) {
        $semesterName_err = '&nbsp;&nbsp;&nbsp;請輸入學期名';
    } else {
        $semesterName = trim($_POST['semesterName']);
    }
    // Check input errors before inserting in database
    if (empty($startDate_err) && empty($endDate_err) && empty($semesterName_err)) {
        // Prepare an insert statement
        $sql = "INSERT INTO `semester` (`id`, `startDate`, `endDate`, `semesterName`) VALUES (NULL, :startDate, :endDate, :semesterName)";
        if ($stmt = $pdo->prepare($sql)) {
            $stmt->bindParam(':startDate', $startDate, PDO::PARAM_STR);
            $stmt->bindParam(':endDate', $endDate, PDO::PARAM_STR);
            $stmt->bindParam(':semesterName', $semesterName, PDO::PARAM_STR);
            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
              echo "<script language='javascript'>
                    alert('新增學期成功');
                    window.open('/semestertool.php', '_self')
                    </script>";
                exit();

            } else {
                echo '<script language="javascript">';
                echo 'alert("錯誤![註冊-指令錯誤102]");';
                echo '</script>';
            }
        }
        // Close statement
        unset($stmt);
    }
    // Close connection
    unset($pdo);
}

?>