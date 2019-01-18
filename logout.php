<?php
session_start();
session_destroy();
echo "<script language='javascript'>
                    alert('登出成功');
                    window.open('/semestertool.php', '_self')
                    </script>";

header("location: index.php");
