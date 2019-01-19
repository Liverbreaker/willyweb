<?php
    print_r($_POST);
    $reg_date = trim($_POST["reg_date"]);
    $reg_building = trim($_POST['reg_building']);
    $reg_username = trim($_SESSION['username']);
    $reg_classroom = trim($_POST['reg_classroom']);
    $stime = explode("_",trim($_POST['reg_time_start']))[0];
    $etime = explode("_",trim($_POST['reg_time_end']))[1];
    $reg_semester = explode("_",trim($_POST['reg_semester']));
    $reg_semester_week = $_POST['reg_semester_week'];

    echo "<br>==1==<br>";
    for ($i=0; $i < count($reg_semester_week); $i++) {
        echo $reg_semester_week[$i]. " "; 
    }
    echo "<br>==2==<br>";
    // set date range 
    $dates = dateRange($reg_semester[1], $reg_semester[2]);
    $alldays = array_filter($dates, dateFilter($reg_semester_week));
    
    echo "<br>==3==<br>";
    // echo json_encode( $alldays );
    echo $stime;
    echo "<br>==3==<br>";
    echo intval( explode(":",$stime)[0] ) . intval( explode(":",$stime)[1] );
    echo "<br>==4==<br>";
    echo $etime;
    echo "<br>==4==<br>";
    echo intval( explode(":",$etime)[0] ) . intval( explode(":",$etime)[1] );
    // echo date_create( datetime($alldays[0]) . $stime );
    // for ($i=0; $i < count($alldays); $i++) { 
    //     echo $alldays['date']->format('Y-m-d H:i:s'). " ";
    // }
    echo "<br>==5==<br>";
    
    echo "<br>==6==<br>";
    $stime0 = intval( explode(":",$stime)[0] );
    $stime1 = intval( explode(":",$stime)[1] );
    $etime0 = intval( explode(":",$etime)[0] );
    $etime1 = intval( explode(":",$etime)[1] );



    foreach ($alldays as $key => $val) {
        echo $key;
        echo date_time_set($val,$stime0,$stime1)->format('Y-m-d H:i:s D');
        echo " _ ";
        echo date_time_set($val,$etime0,$etime1)->format('Y-m-d H:i:s D');
        echo " <br> ";
    }
    echo "<br>==7==<br>";

    echo "<br>==8==<br>";

    // $myday = date_create("2019-01-20");
    // $myday = new DateTime($myday);
    // echo "<br><br><br>" . date_format($myday, 'Y-m-d H:i:s') . "<br>";

function dateRange($begin, $end, $interval = null){
    $begin = date_create($begin);
    $end = date_create($end);
    // Because DatePeriod does not include the last date specified.
    $end = $end->modify('+1 day');
    $interval = new DateInterval($interval ? $interval : 'P1D');
    return iterator_to_array(new DatePeriod($begin, $interval, $end)); }
function dateFilter(array $daysOfTheWeek){
    return function ($date) use ($daysOfTheWeek) {
        return in_array($date->format('l'), $daysOfTheWeek);
    }; }
function display($date) { echo $date->format("D Y-m-d")."<br>"; }

echo "<br>==a==<br>";
array_walk(array_filter($dates, dateFilter(['Monday'])), 'display');
echo "<br>==b==<br>";
echo json_encode( array_filter($dates, dateFilter(['Monday'])) );
echo "<br>==c==<br>";
echo "<br>==d==<br>";
array_walk( array_filter($dates, dateFilter($reg_semester_week)) , 'display');
echo "<br>==e==<br>";
echo "<br>=====<br>";
echo "<br>=====<br>";
array_walk(array_filter($dates, dateFilter(['Saturday', 'Sunday'])), 'display');
echo "<br>=====<br>";
echo "<br>=====<br>";
echo "<br>=====<br>";