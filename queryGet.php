<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once( '/conf/config.php' );

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


// get building list
if ($_GET['get'] == 'buildings') { getBuildings(); };
function getBuildings()
{
    $sql = "SELECT name, ID FROM willyschool.building;"; // get building name, id from building DB
    try {
        $stmt = $pdo->prepare($sql);
        if ($stmt->execute()) {
            $result = $stmt->fetchAll();
            foreach ($result as $row) {
                // echo "<option to='" . $row['ID'] . "'>" . $row['name'] . "</option>";
                echo "<html><body>success tested sql: ".$sql."</body></html>";
            }
        };
    } catch (PDOException $e) {
        echo "Error:" . $e->getMessage();
    }
    unset($this);
}

// get classroom list
if ($_GET['get'] == 'classroom') { getClassroom(); };
function getClassroom()
{
    $sql = '';
    try {
        '';
    } catch (PDOException $e) {
        echo "Error:" . $e->getMessage();
    }
}


//////////////////////
// get sth function: template
if ($_GET['get'] == 'name') { getName(); };
function getName() // initial function looks this way
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
