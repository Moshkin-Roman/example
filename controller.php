<?php
    session_start();
    if(!empty($_SESSION['adm']) && !empty($_POST['action'])){
        $db ='test2';
        $db_user = 'user';
        $db_pass = 'test';
        
        $mysqli = new mysqli('localhost', $db_user, $db_pass, $db);
        
        if ($mysqli->connect_errno) { 
            echo "Oшибка: " . $mysqli->connect_error . "\n";
        }
        
        $mysqli->set_charset("utf8");
        
        aplly_request($_POST['action']);
    } else {
        echo "fail";
    }
    
    function aplly_request($action) {
        global $mysqli;
        switch($action) {
            case "activate":
                if(!empty($_POST['id'])) {
                    $id = $_POST['id'];
                    $sql = "UPDATE comments SET allowed='1' WHERE comm_id='$id'";
                        if ($result = $mysqli->query($sql)) {
                            echo "ok";
                        } else {
                            echo "fail";
                        }
                }
                break;
                
            case "lock":
                if(!empty($_POST['id'])) {
                    $id = $_POST['id'];
                    $sql = "UPDATE comments SET allowed='0' WHERE comm_id='$id'";
                        if ($result = $mysqli->query($sql)) {
                            echo "ok";
                        } else {
                            echo "fail";
                        }
                }
                break;                
            
        }
    }
    
?>