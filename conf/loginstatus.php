<html>
<body>
<?php
if ( session_status() == PHP_SESSION_NONE ){
	session_start();
}
require_once( 'config.php' );
echo "username: ".$_SESSION['username'];
echo "<br>";
echo "nickname: ".$_SESSION['nickname'];
echo "<br>";
echo "permission: ".$_SESSION['permission'];
?>
</body>
</html>