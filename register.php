<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once('config.php');
$username = $nickname = $email = $password = $confirm_password = null;
$username_err = $nickname_err = $email_err = $password_err = $confirm_password_err = null;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty(trim($_POST["username"]))) {
        $username_err = "&nbsp;&nbsp;&nbsp;請輸入帳號";
    } else {
        $sql = "SELECT username FROM users WHERE username = :username";
        if ($stmt = $pdo->prepare($sql)) {
            $stmt->bindParam(':username', $param_username, PDO::PARAM_STR);
            $param_username = trim($_POST["username"]);
            if ($stmt->execute()) {
                if ($stmt->rowCount() == 1) {
                    $username_err = "&nbsp;&nbsp;&nbsp;帳號已存在";
                } else {
                    $username = trim($_POST["username"]);
                }
            } else {
                echo "錯誤![註冊-帳號錯誤101]";
            }
        }
        unset($stmt);
    }
    if (empty(trim($_POST['password']))) {
        $password_err = "&nbsp;&nbsp;&nbsp;請輸入密碼";
    } elseif (strlen(trim($_POST['password'])) < 6) {
        $password_err = "&nbsp;&nbsp;&nbsp;密碼長度不足6個字元";
    } else {
        $password = trim($_POST['password']);
    }
    if (empty(trim($_POST["confirm_password"]))) {
        $confirm_password_err = '&nbsp;&nbsp;&nbsp;請輸入確認密碼';
    } else {
        $confirm_password = trim($_POST['confirm_password']);
        if ($password != $confirm_password) {
            $confirm_password_err = '&nbsp;&nbsp;&nbsp;確認密碼不相同';
        }
    }
    if (empty(trim($_POST["nickname"]))) {
        $nickname_err = '&nbsp;&nbsp;&nbsp;請輸入姓名';
    }
    if (empty(trim($_POST["email"]))) {
        $email_err = '&nbsp;&nbsp;&nbsp;請輸入email';
    }
    // Check input errors before inserting in database
    if (empty($username_err) && empty($password_err) && empty($confirm_password_err) && empty($nickname_err) && empty($email_err)) {
        // Prepare an insert statement
        $sql = "INSERT INTO users (id, username, password, nickname, email, permission) VALUES (NULL, :username, :password, :nickname, :email, 'teacher')";
        if ($stmt = $pdo->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(':username', $param_username, PDO::PARAM_STR);
            $stmt->bindParam(':password', $param_password, PDO::PARAM_STR);
            $stmt->bindParam(':nickname', $nickname, PDO::PARAM_STR);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            //$stmt->bindParam(':permission', $param_permission, PDO::PARAM_STR);
            // Set parameters
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            $nickname = trim($_POST['nickname']);
            $email = trim($_POST['email']);
            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
              echo "<script language='javascript'>
                    alert('註冊成功,請登入');
                    window.open('/index.php', '_self')
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
    <h1>註冊新帳號</h1>
    <p>請填入以下欄位</p>
    <hr>

    <label for="username"><b>教師代碼</b></label><span><?php echo $username_err; ?></span>
    <input type="text" placeholder="請填入 教師代碼" name="username" required>

    <label for="nickname"><b>姓名</b></label>
    <input type="text" placeholder="請填入 姓名" name="nickname" required>

    <label for="email"><b>Email</b></label>
    <input type="text" placeholder="請填入 Email" name="email" required>

    <label for="password"><b>密碼</b></label><span><?php echo $password_err; ?></span>
    <input type="password" placeholder="請填入密碼" name="password" required>

    <label for="confirm_password"><b>再次輸入密碼</b></label><span><?php echo $confirm_password_err; ?></span>
    <input type="password" placeholder="請再次輸入密碼" name="confirm_password" required>
    <hr>

    <p>若無教師代號請洽輔仁大學XX處 電話:<a href="#">02-29052000</a>.</p>
    <button type="submit" class="registerbtn">註冊</button>
  </div>

</form>
</body>
</html>