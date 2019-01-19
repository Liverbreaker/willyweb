<?php
$sql = $_GET['sql'];
try {
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    if ($row = $stmt->fetchAll()) {
        foreach ($row as $row) {
            echo "<option sfrom='" . $row['startDate'] . "' sto='" . $row['endDate'] . "' sname='" . $row['semesterName'] . "'>" . $row['semesterName'] . "</option>";
        }
    }
} catch (PDOException $e) {
    echo "Error:" . $e->getMessage();
}
unset($pdo);
unset($stmt);
unset($sql);
?>