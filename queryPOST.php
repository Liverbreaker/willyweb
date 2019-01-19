<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once 'config.php';
if (isset($_POST['var1'])) {
    $var1 = $_POST['var1'];
}
if (isset($_POST['var2'])) {
    $var2 = $_POST['var2'];
}
if (isset($_POST['sql'])) {
    $sql = $_POST['sql'];
    try {
		$stmt = $pdo->prepare($sql);
		$stmt->bindParam(':var1', $var1, PDO::PARAM_STR);
		$stmt->bindParam(':var2', $var2, PDO::PARAM_STR);
        if ($stmt->execute()) {
			return "done sql: ".$sql;
        }
    } catch (PDOEXception $e) {
        echo "Error:" . $e->getMessage();
    }
}
