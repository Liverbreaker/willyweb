<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once('config.php');
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
<html>
<head>
	<link rel="stylesheet" href="css/rejister.css">
</head>
<body>
<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
  <div class="container">
    <h1>增加新學期區間</h1>
    <p>請填入以下欄位</p>
    <hr>
      
    <div class='row'>
    <label for="startDate"><b>起始日</b></label>
    <input type="date" name="startDate" required>
    </div>
    <div class='row'>
    <label for="endDate"><b>終止日</b></label>
    <input type="date" name="endDate" required>
    </div>
    <div class='row'>
    <label for="semesterName"><b>學期名</b></label>
    <input type="text" placeholder="請填入 學期名" name="semesterName" required>
    </div>
    <hr>

    <p>若無教師代號請洽輔仁大學XX處 電話:<a href="#">02-29052000</a>.</p>
    <button type="submit" class="registerbtn">提交</button>
  </div>

</form>
</body>
</html>