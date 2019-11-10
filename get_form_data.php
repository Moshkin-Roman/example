<?php

    if(!empty($_POST['name']) && !empty($_POST['email']) && !empty($_POST['msg'])){ 
        $name = $_POST['name'];
        $email = $_POST['email'];
        $msg = $_POST['msg'];
        $result = add_comment($name, $email, $msg);
        echo ($result);
        exit;
    }
    
    function add_comment($name, $email, $msg) {
        $db ='test2';
        $db_user = 'user';
        $db_pass = 'test';
        
        $mysqli = new mysqli('localhost', $db_user, $db_pass, $db);
        
        if ($mysqli->connect_errno) { 
            echo "ќшибка: " . $mysqli->connect_error . "\n";
        }
        
        $mysqli->set_charset("utf8");
        $sql = "INSERT INTO comments SET comm_name='$name', comm_email='$email', comment='$msg'";
        
        if ($result = $mysqli->query($sql)) {
            return "ok";
        } else {
            return "fail";
        }
    }
?>