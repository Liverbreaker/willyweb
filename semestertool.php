<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once 'config.php';

?>
<html>

<head>
    <meta charset='UTF-8'>
    <title>學期期間管理工具</title>
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
    <?php include 'navbar.php';?>
    <div name="record">
        <div><a href="/newsemester.php">增加新學期</a></div>
        <table class='table table-hover'>
            <thead>
                <th>No.</th>
                <th>學期名稱</th>
                <th>學期始自</th>
                <th>學期終於</th>
                <th>刪除</th>
            </thead>
            <tbody id='userlist'>
                <?php
try {
    $stmt = $pdo->prepare("SELECT * FROM `semester`");
    $stmt->execute();
    if ($row = $stmt->fetchAll()) {
        foreach ($row as $row) {
            if($row['permission']=='admin'){
                $perm = "<option value='teacher'>教師</option><option value='admin' selected>管理者</option>";
            } else {
                $perm = "<option value='teacher' selected>教師</option><option value='admin'>管理者</option>";
            }
            echo "<tr>";
            echo "<td>" . $row['id'] . "</td><td>" . $row['semesterName'] . "</td><td>" . $row['startDate'] . "</td><td>" . $row['endDate'] . "</td><td id='" . $row['id'] . "'><button type='button' class='btn btn-danger' name='deleteSemester' target='" . $row['id'] . "'>刪除</button></td>";
            echo "</tr>";
        }
    } else {
        echo "";
    }
    ;
} catch (PDOEXception $e) {
    echo "Error:" . $e->getMessage();
}
?>
            </tbody>
        </table>
    </div>
</body>

</html>