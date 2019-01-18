<?php
    $fileMap = array(
        0 => "./index.php",
        1 => "./record.php",
        2 => "./admintool.php"
    );
    if(isset($_GET['to'])) {
        $fileKey = $_GET['to'];
        $loadableFile = $fileMap[$fileKey];
        if (file_exists($loadableFile)){
            require_once $loadableFile;
        } else {
            header("location: index.php");
            exit;
        }
    }
    header("location: index.php");