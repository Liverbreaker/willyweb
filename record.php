<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once '/conf/config.php';
?>
<html>
<head>
    <meta charset='UTF-8'>
    <title>個人預借紀錄</title>
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <link rel='stylesheet' href='/css/font-awesome.min.css'>
    <link rel='stylesheet' href='/css/cal/fullcalendar.css' />
    <link rel='stylesheet' href='/css/cal/scheduler.css' />
    <link rel='stylesheet' href='/css/navbar.css'>
    <link rel='stylesheet' href='/css/modal.css' />

    <script src="/js/jquery.min.js"></script>
    <script src="/js/bootstrap.min.js"></script>
    <script src='/js/cal/moment.min.js'></script>
    <script src='/js/cal/fullcalendar.js'></script>
    <script src='/js/cal/scheduler.js'></script>
    <script src='/js/main.js'></script>
</head>
<body>
    <?php include 'navbar.php';?>
    <div id='rtable' class='container' style='margin-top: 20px;'></div>
    <div id="EventModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <span id='closeModal' class="close">&times;</span>
                <h2>Modal Header</h2>
            </div>
            <div class="modal-body"></div>
            <div class="modal-footer">
                <h3>Modal Footer</h3>
            </div>
        </div>
    </div>
</body>
</html>