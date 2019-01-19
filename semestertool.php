<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once '/conf/config.php';
if(!isset($_SESSION['username'])){
	header("location: redirect.php?to=0");
	exit();
}
?>
<html>
<head>
    <meta charset='UTF-8'>
    <title>學期期間管理</title>
	<link rel="stylesheet" href="/css/bootstrap.min.css">
	<link rel='stylesheet' href='/css/font-awesome.min.css'>
	<link rel='stylesheet' href='/css/navbar.css'>
    <link rel='stylesheet' href='/css/modal.css' />
    <link rel='stylesheet' href='/css/datepicker/bootstrap-datepicker.min.css' />
	<script src="/js/jquery.min.js"></script>
	<script src="/js/bootstrap.min.js"></script>
    <script src="/js/bootstrap-datepicker.min.js"></script>
	<script src='/js/main.js'></script>
</head>
<body>
    <?php include 'navbar.php';?>
    <div name="record" class='container'>
        <div>
            <button class='btn btn-danger' id='modal1'>新增新學期區間</button>
        </div>
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
            $myecho = "<tr>
                        <td>:id</td>
                        <td>:semesterName</td>
                        <td>:startDate</td>
                        <td>:endDate</td>
                        <td id=':id'>
                            <button type='button' class='btn btn-danger' target=':id' to=':semesterName' id='deleteSemester_:semesterName'>刪除</button>
                        </td>
                    </tr>";
            $myecho = str_replace(':id',$row['id'], $myecho);
            $myecho = str_replace(':semesterName',$row['semesterName'], $myecho);
            $myecho = str_replace(':startDate',$row['startDate'], $myecho);
            $myecho = str_replace(':endDate',$row['endDate'], $myecho);
            echo $myecho;
        }
    }
} catch (PDOEXception $e) {
    echo "Error:" . $e->getMessage();
}
?>
            </tbody>
        </table>
    </div>
    <div id="SemesterModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <span id='closeModal' class="close">&times;</span>
                <h2></h2>
                <p></p>
            </div>
            <div class="modal-body"></div>
        </div>
    </div>
</body>

</html>