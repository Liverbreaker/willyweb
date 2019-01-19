<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once '/conf/config.php';
if (isset($_POST['var1'])) {
    $var1 = $_POST['var1'];
}
if (isset($_POST['var2'])) {
    $var2 = $_POST['var2'];
}
if (isset($_POST['var3'])) {
    $var1 = $_POST['var3'];
}
if (isset($_POST['var4'])) {
    $var2 = $_POST['var4'];
}
if (isset($_POST['sql'])) {
    $sql = $_POST['sql'];
    try {
        $stmt = $pdo->prepare($sql);
        if (isset($_POST['var1'])) {
            $stmt->bindParam(':var1', $var1, PDO::PARAM_STR);
        }
        if (isset($_POST['var2'])) {
            $stmt->bindParam(':var2', $var2, PDO::PARAM_STR);
        }
        if (isset($_POST['var3'])) {
            $stmt->bindParam(':var3', $var3, PDO::PARAM_STR);
        }
        if (isset($_POST['var4'])) {
            $stmt->bindParam(':var4', $var4, PDO::PARAM_STR);
        }
        if ($stmt->execute()) {
			echo "done sql: ".$sql;
        }
    } catch (PDOEXception $e) {
        echo "Error:" . $e->getMessage();
    }
}
