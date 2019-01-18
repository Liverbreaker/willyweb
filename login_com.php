<?php
require_once( 'config.php' );
if ( session_status() == PHP_SESSION_NONE ) {
	session_start();
}
$username = trim( $_POST[ 'username' ] );
$password = trim( $_POST[ 'password' ] );

if ( $_SERVER[ 'REQUEST_METHOD' ] == "POST" ) {
	// Validate credentials
	$sql = "SELECT `username`,`nickname`,`password`,`permission` FROM `users` WHERE `username` = :username";
	if ( $stmt = $pdo->prepare( $sql ) ) {
		$stmt->bindParam( ':username', $username, PDO::PARAM_STR );
		if ( $stmt->execute() ) {
			if ( $stmt->rowCount() == 1 ) {
				if ( $row = $stmt->fetch() ) {
					$hashed_password = $row[ 'password' ];
					if ( password_verify( $password, $hashed_password ) ) {
						// password correct, start new session
						$_SESSION[ 'username' ] = $username;
						$_SESSION[ 'permission' ] = $row[ 'permission' ];
						$_SESSION[ 'nickname' ] = $row[ 'nickname' ];
						header("location: redirect.php?to=0"); // success
					} else {
						echo "failed login";
					}
				}
			} else {
				echo "no user";
			}
		} else {
			echo "error";
		}
	}
	unset( $row );
	unset( $stmt );
	unset( $pdo );
	unset( $username );
	unset( $password );
	unset( $hashed_password );
}
?>