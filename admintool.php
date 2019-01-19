<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once 'config.php';

?>
<html>

<head>
    <meta charset='UTF-8'>
    <title>教室預借系統</title>
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
        <div><a href="/register.php">註冊新帳號</a></div>
        <table class='table table-hover'>
            <thead>
                <th>使用者名稱</th>
                <th>暱稱</th>
                <th>E-mail</th>
                <th>權限</th>
                <th>刪除</th>
            </thead>
            <tbody id='userlist'>
                <?php
try {
    $stmt = $pdo->prepare("SELECT * FROM `users`");
    $stmt->execute();
    if ($row = $stmt->fetchAll()) {
        foreach ($row as $row) {
            if($row['permission']=='admin'){
                $perm = "<option value='teacher'>教師</option><option value='admin' selected>管理者</option>";
            } else {
                $perm = "<option value='teacher' selected>教師</option><option value='admin'>管理者</option>";
            }
            echo "<tr>";
            echo "<td>" . $row['username'] . "</td><td>" . $row['nickname'] . "</td><td>" . $row['email'] . "</td><td><div class='form-check form-check-inline'>
                            <input class='form-check-input' type='checkbox' name='isFix' to='" .$row['username']. "'><label class='form-check-label' for='gridCheck'>修改</label>
                            </div><select name='s_permit' id='permission_" .$row['username']. "' class='form-control' disabled>". $perm."</select></td><td><button type='button' class='btn btn-danger' name='deleteUser' target='" . $row['username'] . "'>刪除</button><button style='display:none' type='button' class='btn btn-success' name='saveUser' target='".$row['username']."' id='saveUser_" . $row['username'] . "'>儲存</button></td>";
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