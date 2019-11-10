<?php
    if($_POST['login'] == "admin" && $_POST['passwd'] == "123"){
        echo ("verified");
    } else {
        echo ("fail");
    }
?>