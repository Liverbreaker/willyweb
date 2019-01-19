<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once '/conf/config.php';
if(!isset($_SESSION['username']) || ($_SESSION['permission'] !== 'admin')){
	header("location: redirect.php?to=0");
	exit();
}
?>
<html>
<head>
    <meta charset='UTF-8'>
    <title>管理者工具</title>
	<link rel="stylesheet" href="/css/bootstrap.min.css">
	<link rel='stylesheet' href='/css/font-awesome.min.css'>
    <link rel='stylesheet' href='/css/navbar.css'>
	<script src="/js/jquery.min.js"></script>
	<script src="/js/bootstrap.min.js"></script>
	<script src='/js/main.js'></script>
</head>

<body>
    <?php include 'navbar.php';?>
    <div name="record" class='container'>
        <div><a href="/register.php">註冊新帳號</a></div>
        <table class='table table-hover'>
            <thead>
                <th class='col-sm-2'>使用者名稱</th>
                <th class='col-sm-2'>暱稱</th>
                <th class='col-sm-2'>E-mail</th>
                <th class='col-sm-4'>權限</th>
                <th class='col-sm-2'>刪除</th>
            </thead>
            <tbody id='userlist'>
<?php
try {
    $stmt = $pdo->prepare("SELECT * FROM `users`");
    $stmt->execute();
    if ($row = $stmt->fetchAll()) {
        foreach ($row as $row) {
            if ($row['permission'] == 'admin') {
                $perm = "<option value='teacher'>教師</option><option value='admin' selected>管理者</option>";
            } else {
                $perm = "<option value='teacher' selected>教師</option><option value='admin'>管理者</option>";
            }
            $myecho = "<tr>
                        <td>:username</td>
                        <td>:nickname</td>
                        <td>:email</td>
                        <td>
                            <div class='form-check form-check-inline'>
                                <input type='checkbox' class='form-check-input' id='isFix_:username' target=':username'>
                                <label class='form-check-label' for='isFix_:username'>修改</label>
                                <select class='form-control' id='permission_:username' disabled>:perm</select>
                            </div>
                        </td>
                        <td>
                            <button type='button' class='btn btn-danger' target=':id' to=':username' id='deleteUser_:username'>刪除</button>
                            <button type='button' class='btn btn-success' target=':id' to=':username' id='saveUser_:username' style='display:none'>儲存</button>
                        </td>
                        </tr>";
            $myecho = str_replace(':username',$row['username'], $myecho);
            $myecho = str_replace(':nickname',$row['nickname'], $myecho);
            $myecho = str_replace(':email',$row['email'], $myecho);
            $myecho = str_replace(':perm',$perm, $myecho);
            $myecho = str_replace(':id',$row['id'], $myecho);
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
</body>

</html>