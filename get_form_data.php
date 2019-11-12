<?php
    $db ='test2';
    $db_user = 'user';
    $db_pass = 'test';
    
    $mysqli = new mysqli('localhost', $db_user, $db_pass, $db);
    
    if ($mysqli->connect_errno) { 
        echo "Oшибка: " . $mysqli->connect_error . "\n";
    }

    if(!empty($_POST['name']) && !empty($_POST['email']) && !empty($_POST['msg'])){ 
        $name = htmlspecialchars($_POST['name']);
        $email = htmlspecialchars($_POST['email']);
        $msg = htmlspecialchars($_POST['msg']);
        
        $last_id = add_comment($name, $email, $msg);
        if (isset($_FILES) && $last_id) {
            if (ad_file($last_id)) echo ("ok");
        }
        exit;
    }
    
    function add_comment($name, $email, $msg) {
        global $mysqli;
                
        if ($mysqli->connect_errno) { 
            echo "Oшибка: " . $mysqli->connect_error . "\n";
        }
        
        $mysqli->set_charset("utf8");
        $sql = "INSERT INTO comments SET comm_name='$name', comm_email='$email', comment='$msg'";
        
        if ($result = $mysqli->query($sql)) {
            return $mysqli->insert_id;
        } else {
            return "fail";
        }
    }
    
    function ad_file($comm_id) {
        if (empty($comm_id)) return false;
        global $mysqli;
        $uploaddir = 'images/';
        $uploadfile = $uploaddir . basename($_FILES['img']['name']);

        if (move_uploaded_file($_FILES['img']['tmp_name'], $uploadfile)) {
            $mysqli->set_charset("utf8");
            $flname = 'images/' .basename($_FILES['img']['name']);
            
            make_preview($flname);
            
            $sql = "INSERT INTO picters SET comm_id='$comm_id', pic_url='$flname'";
            
            if ($result = $mysqli->query($sql)) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
    
    function make_preview($source) {
        $width = 320;
        $height = 240;
        $rgb = 0xffffff;
        $size = getimagesize($source);
        $format = strtolower(substr($size['mime'], strpos($size['mime'], '/')+1));
        $icfunc = "imagecreatefrom" . $format;
        if (!function_exists($icfunc)) return false;
        $x_ratio = $width / $size[0];
        $y_ratio = $height / $size[1];
        $ratio = min($x_ratio, $y_ratio);
        $use_x_ratio = ($x_ratio == $ratio);
        $new_width = $use_x_ratio  ? $width  : floor($size[0] * $ratio);
        $new_height = !$use_x_ratio ? $height : floor($size[1] * $ratio);
        $new_left = $use_x_ratio  ? 0 : floor(($width - $new_width) / 2);
        $new_top = !$use_x_ratio ? 0 : floor(($height - $new_height) / 2);
        $img = imagecreatetruecolor($width,$height);
        imagefill($img, 0, 0, $rgb);
        $photo = $icfunc($source);
        imagecopyresampled($img, $photo, $new_left, $new_top, 0, 0, $new_width, $new_height, $size[0], $size[1]);
        imagejpeg($img, $source);
        imagedestroy($img);
        imagedestroy($photo);
    }
?>