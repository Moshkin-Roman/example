<?php
    session_start();
    if ($_POST['login'] == "admin" && $_POST['passwd'] == "123"){
        $_SESSION['adm'] = 1;
        echo ("verified");
    } else {
        echo ("fail");
    }
    
    if (!empty($_POST['deauth'])) {
        session_destroy();
    }
?>