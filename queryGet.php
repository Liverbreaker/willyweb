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
    getRecord($pdo);
} else if ($_GET['get'] == ''){

} else if ($_GET['get'] == ''){

} else if ($_GET['get'] == ''){

} else if ($_GET['get'] == ''){

} else if ($_GET['get'] == ''){

}



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
    // $sql = "SELECT * FROM `willyschool`.`reserverecord` WHERE (`buildingID` = :building and `classroomID` = :classroom) and (`start` between :time_start and :time_end)";
    $sql = "SELECT * FROM `willyschool`.`record`"; // test
    try{
        $stmt = $pdo->prepare($sql);
        // $stmt->execute(['building' => $_GET['building'], 'classroom' => $_GET['classroom'], 'time_start' => $_GET['time_start'], 'time_end' => $_GET['time_end']]);
        $stmt->execute();
        if ($row = $stmt->fetchAll()) {
            foreach($row as $row){
                echo $row['id'] . "<br>";
                // echo "<tr>";
                // echo "<td>".$row['start']."</td><td>".$row['end']."</td><td>".$row['userID']."</td><td>".$row['buildingID']."</td><td>".$row['classroomID']."</td>";
                // echo "</tr>";
            }
        }
    } catch (PDOEXception $e) {
        echo $sql . "<br>";
        echo $_GET['building'] . "<br>" . $_GET['classroom'] . "<br>" . $_GET['time_start']. "<br>" . $_GET['time_end'] . "<br>" ;
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