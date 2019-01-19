<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once '/conf/config.php';

////// query get with functions //////

//// some useful tips:
//
// simple execution:
// $stmt = $pdo->prepare('SELECT * FROM users WHERE email = :email AND status=:status');
// $stmt->execute(['email' => $email, 'status' => $status]);
// or use bindParam()
//
// multiple execution:
// $stmt = $pdo->prepare('UPDATE users SET bonus = bonus + ? WHERE id = ?');
// foreach ($data as $id => $bonus) { $stmt->execute([$bonus, $id]); }
//
//// some useful sites:
// http://php.net/manual/en/pdo.prepare.php
// https://phpdelusions.net/pdo

if ($_GET['get'] == 'buildings') {
    getBuildings($pdo);
} else if ($_GET['get'] == 'classroom') {
    getClassroom($pdo);
} else if ($_GET['get'] == 'record') {
    // echo "hi";
    getRecord($pdo);
} else if ($_GET['get'] == ''){

} else if ($_GET['get'] == ''){

} else if ($_GET['get'] == ''){

} else if ($_GET['get'] == ''){

} else if ($_GET['get'] == ''){

}
// $sql = "SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_TYPE = 'BASE TABLE' AND TABLE_SCHEMA='willyschool';";


if ( isset($_POST['sql']) ) {
    $sql = $_POST['sql'];
} else if (isset ($_GET['sql'] ) ) {
    $sql = $_GET['sql'];
}

// get building list
function getBuildings(&$pdo)
{
    $sql = "SELECT name, ID FROM `willyschool`.`buildings`;"; // get building name, id from building DB
    try {
        $stmt = $pdo->prepare($sql);
        if ($stmt->execute()) {
            $result = $stmt->fetchAll();
            foreach ($result as $row) {
                echo "<option to='" . $row['ID'] . "'>" . $row['name'] . "</option>";
            }
        }
        ;
    } catch (PDOException $e) {
        echo "Error:" . $e->getMessage();
    }
    unset($this);
}

// get classroom list
function getClassroom(&$pdo)
{
    class TableRows extends RecursiveIteratorIterator
    {
        public function __construct($it)
        {
            parent::__construct($it, self::LEAVES_ONLY);
        }
        public function current()
        {
            return "<option to='" . parent::current() . "'>" . parent::current() . "</option>";
        } // .parent::current()  //parent::key()
    }
    $sql = "SELECT DISTINCT classroomId FROM `willyschool`.`classroom` WHERE `building` = '" . $_GET['building'] . "';";
    try {
        $stmt = $pdo->prepare($sql);
        if ($stmt->execute()) {
            $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
            foreach (new TableRows(new RecursiveArrayIterator($stmt->fetchAll())) as $k => $v) {
                // $k is col name, $v is value
                echo $v;
            }
        }
    } catch (PDOException $e) {
        echo "Error:" . $e->getMessage();
    }
}

// get record
function getRecord(&$pdo) // initial function looks this way
{
    if ($_GET['WithUserID'] == 'true' ) {
        if (isset($_GET['building'])) {
            if (isset($_GET['classroom'])) {
                $sql = "SELECT id, DATE_FORMAT(start, '%Y-%m-%dT%T') AS `start`, DATE_FORMAT(end, '%Y-%m-%dT%T') AS `end`, userID, CONCAT(buildingID, '', classroomID) AS title FROM `willyschool`.`reserve` WHERE buildingID = :building and classroomID = :classroom and userID = :userID ";
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':building', $_GET['building'], PDO::PARAM_STR);
                $stmt->bindParam(':classroom', $_GET['classroom'], PDO::PARAM_STR);
                $stmt->bindParam(':userID', $_SESSION['username'], PDO::PARAM_STR);
            } else {
                $sql = "SELECT id, DATE_FORMAT(start, '%Y-%m-%dT%T') AS `start`, DATE_FORMAT(end, '%Y-%m-%dT%T') AS `end`, userID, CONCAT(buildingID, '', classroomID) AS title FROM `willyschool`.`reserve` WHERE buildingID = :building and userID = :userID ";
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':building', $_GET['building'], PDO::PARAM_STR);
                $stmt->bindParam(':userID', $_SESSION['username'], PDO::PARAM_STR);
            }
        } else {
            $sql = "SELECT id, DATE_FORMAT(start, '%Y-%m-%dT%T') AS `start`, DATE_FORMAT(end, '%Y-%m-%dT%T') AS `end`, userID, CONCAT(buildingID, '', classroomID) AS title  FROM `willyschool`.`reserve` WHERE userID = :userID ";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':userID', $_SESSION['username'], PDO::PARAM_STR);
        }
    } else {
        if (isset($_GET['building'])) {
            if (isset($_GET['classroom'])) {
                $sql = "SELECT id, DATE_FORMAT(start, '%Y-%m-%dT%T') AS start, DATE_FORMAT(end, '%Y-%m-%dT%T') AS end, userID AS title, CONCAT(buildingID, '', classroomID) AS resourceId FROM `willyschool`.`reserve` WHERE buildingID = :building and classroomID = :classroom ";
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':building', $_GET['building'], PDO::PARAM_STR);
                $stmt->bindParam(':classroom', $_GET['classroom'], PDO::PARAM_STR);
            } else {
                $sql = "SELECT id, DATE_FORMAT(start, '%Y-%m-%dT%T') AS start, DATE_FORMAT(end, '%Y-%m-%dT%T') AS end, userID AS title, CONCAT(buildingID, '', classroomID) AS resourceId FROM `willyschool`.`reserve` WHERE buildingID = :building ";
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':building', $_GET['building'], PDO::PARAM_STR);
            }
        } else {
            $sql = "SELECT id, DATE_FORMAT(start, '%Y-%m-%dT%T') AS start, DATE_FORMAT(end, '%Y-%m-%dT%T') AS end, userID AS title, CONCAT(buildingID, '', classroomID) AS resourceId FROM `willyschool`.`reserve` ";
            $stmt = $pdo->prepare($sql);
        }
    }

    try{
        $stmt->execute();
        // $stmt->debugDumpParams();
        if ($result = $stmt->fetchAll()) {
            echo json_encode( $result );
        }
    } catch (PDOEXception $e) {
        echo "Error:" . $e->getMessage();
    }
    unset($row);
    unset($stmt);
    unset($sql);
}


//////////////////////
// get sth function: template
function getName(&$pdo) // initial function looks this way
{
    $sql = '';
    try {
        '';
    } catch (PDOException $e) {
        echo "Error:" . $e->getMessage();
    }
}
//////////////////////


?>