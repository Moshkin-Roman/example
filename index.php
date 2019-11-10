<?php

    $adm = 0;

    $db ='test2';
    $db_user = 'user';
    $db_pass = 'test';
    
    $mysqli = new mysqli('localhost', $db_user, $db_pass, $db);
    if ($mysqli->connect_errno) { 
        echo "Ошибка: " . $mysqli->connect_error . "\n";
    }
    
    $mysqli->set_charset("utf8");

    if ($adm == 1) {
        $sql = "SELECT * FROM comments";
    } else {
        $sql = "SELECT * FROM comments WHERE allowed=1";
    }
    
    $str = '';
    
    if ($result = $mysqli->query($sql)) {
        
        while ($row = $result->fetch_assoc()) {
            $img_list = (get_picters($row['comm_id'], $mysqli)) ? get_picters($row['comm_id'], $mysqli) : "";
            $modified = $row['modified'] == 1 ? "<p class='modified'>(изменен администратором)</p>" : "";
            $allowed = $row['allowed'] == 0 ? " on-check" : "";
            
            $str .= (
                '<div class="comment ' . $allowed . '">
                    <div class="comm-date">' . $row['comm_date'] . '</div>'
                    . $modified .
                    '<div class="comm-text">' . $row['comment'] . '</div>
                    ' . $img_list . '
                    <div class="comm-autor">' . $row['comm_name'] . '</div>
                    <div class="comm-email">' . $row['comm_email'] . '</div>                        
                </div>'
            );
        }
    } else {
        echo "Ошибка: " . $mysqli->error . "\n";
    }
    
    function get_picters($comm_id, $mysqli) {
        $img_list = "";
        $sql = "SELECT pic_url FROM picters WHERE comm_id='$comm_id'";
        
        if ($result = $mysqli->query($sql)) {

            while ($row = $result->fetch_assoc()) {
                $img_list .= '<li><img src="' . $row['pic_url'] . '"/></li>';
            }
            
            return "<ul class='img-list'>" . $img_list . "</ul>";
        } else {
            return false;
        }
    }
?>

<!doctype html>
<html lang="ru">
    <head>
        <meta charset="UTF-8">
        <title>Комментарии</title>
        <script src="js/jquery.js"></script>
        <script type="text/javascript" src="js/bootstrap.min.js"></script>
        <script src="js/main.js"></script>
        <link rel="stylesheet" href="css/bootstrap.min.css" type="text/css" media="screen">
        <link rel="stylesheet" href="css/styles.css" type="text/css" media="screen">
    </head>
    <body>
        <div class="container">
            <div class="row">
                <select id="filter">
                    <option value="date">по дате</option>
                    <option value="name">по имени автора</option>
                    <option value="email">по email</option>
                </select>
                <div class="col-sm-6 col-sm-offset-3">
                    <div class="auth">Вход</div>
                    <div class="comm-list">
                        <?php echo $str; ?>
                    </div>
                    <div class="inner-msg"></div>
                    <form class="c-form" action="">
                        <input class="form-control" placeholder="Ваше имя:" type="text" name="name" />
                        <input class="form-control" placeholder="Ваш email:" type="text" name="email" />
                        <input class="form-control" type="file" accept="image/jpeg,image/png,image/gif" name="img" />
                        <textarea  class="form-control" placeholder="Сообщение" rows="10" name="msg"></textarea>
                        <div class="btn btn-success snd-btn">Отправить</div>
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>