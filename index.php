<?php

    $db ='dl';
    $db_user = 'root';
    $db_pass = '';
    
    $mysqli = new mysqli('localhost', $db_user, $db_pass, $db);
    if ($mysqli->connect_errno) { 
        echo "Ошибка: " . $mysqli->connect_error . "\n";
    }
    
    $sql = "SELECT * FROM comments";
    $str = '';
    
    if ($result = $mysqli->query($sql)) {
        while ($row = $result->fetch_assoc()) {
            $str .= (
                '<div class="comment">
                    <div class="comm-date">' . $row['comm_date'] . '</div>
                    <div class="comm-text">' . $row['comment'] . '</div>
                    <div class="comm-autor">' . $row['comm_name'] . '</div>
                    <div class="comm-email">' . $row['comm_email'] . '</div>                        
                </div>'
            );
        }
    } else {
        echo "Ошибка: " . $mysqli->error . "\n";
    }
?>


<!doctype html>
<html lang="ru">
    <head>
        <meta charset="UTF-8">
        <title>Комментарии</title>
        <script src="js/jquery.js"></script>
        <script src="js/main.js"></script>
        <script type="text/javascript" src="js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="css/bootstrap.min.css" type="text/css" media="screen">
        <link rel="stylesheet" href="css/styles.css" type="text/css" media="screen">
    </head>
    <body>
        <div class="container">
            <div class="row">
                <div class="col-sm-6 col-sm-offset-3 comm-list">
                    <?php echo $str; ?>
                    <form class="c-form" action="">
                        <input class="form-control" placeholder="Ваше имя:" type="text" name="name" />
                        <input class="form-control" placeholder="Ваш email:" type="text" name="email" />
                        <input class="form-control" type="file" accept="image/jpeg,image/png,image/gif" name="img" />
                        <textarea  class="form-control" placeholder="Сообщение" rows="10"></textarea>
                        <div class="btn btn-success">Отправить</div>
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>