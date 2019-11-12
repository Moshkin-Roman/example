<?php
    session_start();
    $adm  = !empty($_SESSION['adm']) ? $_SESSION['adm'] : 0;
    
    if ($adm == 1) {
        $login_caption = "Выход";
        $login_class = "de-auth" ;
        $form = "";
        $controls = (
        '<div class="ctrl col-sm-4">
            <i class="fas fa-eye pull-right"></i>
            <i class="fas fa-eye-slash pull-right"></i>
            <i class="fas fa-pencil-alt pull-right"></i>
            <i class="fas fa-save pull-right"></i>
        </div>'
        );
    } else {
        $login_caption = "Вход";
        $login_class = "auth" ;
        $form = '
            <form class="c-form" action="">
                <input class="form-control" placeholder="Ваше имя:" type="text" name="name" />
                <input class="form-control" placeholder="Ваш email:" type="text" name="email" />
                <input class="form-control" type="file" accept="image/jpeg,image/png,image/gif" name="img" />
                <textarea  class="form-control" placeholder="Сообщение" rows="10" name="msg"></textarea>
                <div class="btn btn-success snd-btn">Отправить</div>
            </form>
        ';
        $controls = "";
    }

    $db ='test2';
    $db_user = 'user';
    $db_pass = 'test';
    
    $mysqli = new mysqli('localhost', $db_user, $db_pass, $db);
    if ($mysqli->connect_errno) { 
        echo "Ошибка: " . $mysqli->connect_error . "\n";
    }
    
    $mysqli->set_charset("utf8");

    if ($adm == 1) {
        $sql = "SELECT * FROM comments ORDER BY comm_date DESC";
    } else {
        $sql = "SELECT * FROM comments WHERE allowed=1 ORDER BY comm_date DESC";
    }
    
    $str = '';
    
    if ($result = $mysqli->query($sql)) {
        while ($row = $result->fetch_assoc()) {
            $img_list = (get_picters($row['comm_id'], $mysqli)) ? get_picters($row['comm_id'], $mysqli) : "";
            $modified = $row['modified'] == 1 ? "<p class='modified'>(изменен администратором)</p>" : "";
            $allowed = $row['allowed'] == 0 ? " on-check" : "";
            
            $str .= (
                '<div class="comment ' . $allowed . '" data-id="' . $row['comm_id'] . '">
                    <div class="row">
                        <div class="comm-date col-sm-8">' . $row['comm_date'] . '</div>'
                         . $controls .
                    '</div>'
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
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <script src="js/jquery.js"></script>
        <script type="text/javascript" src="js/bootstrap.min.js"></script>
        <script src="js/main.js"></script>
        <link rel="stylesheet" href="css/bootstrap.min.css" type="text/css" media="screen">
        <link rel="stylesheet" href="css/styles.css" type="text/css" media="screen">
        <link rel="stylesheet" href="css/all.min.css" type="text/css" media="screen">
    </head>
    <body>
        <div class="container">
            <div class="row">
                <div class="col-sm-6 col-sm-offset-3">
                    <div class="top-line clearfix row">
                        <div class="col-xs-6">
                            <select id="filter" class="form-control">
                                <option value="date">по дате</option>
                                <option value="name">по имени автора</option>
                                <option value="email">по email</option>
                            </select>
                        </div>
                        <div class="col-xs-6">
                            <div class="form-control pull-right <?php echo $login_class ?>">
                                <i class="fas fa-user"></i>
                                <?php echo $login_caption; ?>
                            </div>
                        </div>
                    </div>
                    <div class="comm-list">
                        <?php echo $str; ?>
                    </div>
                    <div class="inner-msg"></div>
                    <?php echo $form; ?>
                </div>
            </div>
        </div>
    </body>
</html>