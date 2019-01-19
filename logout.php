<?php
session_start();
session_destroy();
echo "<script language='javascript'>
	alert('登出成功');
	</script>";
header("location: index.php");
