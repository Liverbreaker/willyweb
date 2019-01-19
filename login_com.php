<?php
require_once( '/conf/config.php' );
if ( session_status() == PHP_SESSION_NONE ) {
	session_start();
}
$username = trim( $_POST[ 'username' ] );
$password = trim( $_POST[ 'password' ] );

if ( $_SERVER[ 'REQUEST_METHOD' ] == "POST" ) {
	// Validate credentials
	$sql = "SELECT `username`,`nickname`,`password`,`permission` FROM `willyschool`.`users` WHERE `username` = :username";
	if ( $stmt = $pdo->prepare( $sql ) ) {
		$stmt->bindParam( ':username', $username, PDO::PARAM_STR );
		if ( $stmt->execute() ) {
			if ( $stmt->rowCount() == 1 ) {
				if ( $row = $stmt->fetch() ) {
					$hashed_password = $row[ 'password' ];
					if ( password_verify( $password, $hashed_password ) ) {
						// password correct, start new session
						$_SESSION[ 'username' ] = $row[ 'username' ];
						$_SESSION[ 'permission' ] = $row[ 'permission' ];
						$_SESSION[ 'nickname' ] = $row[ 'nickname' ];
						echo "<script language='javascript'>
							alert('註冊成功,請登入');
							</script>";
						header("location: redirect.php?to=0"); // success
					} else {
						echo "<script language='javascript'>
							alert('登入失敗，請重試 \n login failed, please try again.');
							</script>";
					}
				}
			} else {
				echo "no user";
			}
		} else {
			echo "指令錯誤[login_com.php]";
		}
	}
	unset( $username );
	unset( $password );
	unset( $hashed_password );
}
?>