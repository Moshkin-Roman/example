$(document).ready(function() {
    let box = $('.comm-list');
    
    /*  сортировка  */
    $('#filter').on('change', function() {
        let fltr = $(this).val();
        let comments = $('.comment'); 
        
        switch(fltr) {
            case 'date':
                comments.sort(function(a, b) {
                    let aa = $(a).find('.comm-date').text();
                    let bb = $(b).find('.comm-date').text();
                    let aaa = new Date(aa);
                    let bbb = new Date(bb);

                    if (aaa > bbb) {
                        return 1;
                    }
                    
                    if (aaa < bbb) {
                        return -1;
                    }
                    
                    return 0;
                });
                break;
                
            case 'name':
                comments.sort(function(a, b) {
                    let aa = $(a).find('.comm-autor').text();
                    let bb = $(b).find('.comm-autor').text();

                    if (aa > bb) {
                        return 1;
                    }
                    
                    if (aa < bb) {
                        return -1;
                    }
                    
                    return 0;
                });
                break;                
                
            case 'email':
                comments.sort(function(a, b) {
                    let aa = $(a).find('.comm-email').text();
                    let bb = $(b).find('.comm-email').text();

                    if (aa > bb) {
                        return 1;
                    }
                    
                    if (aa < bb) {
                        return -1;
                    }
                    
                    return 0;
                });
                break;
        }
        
        $.each(comments, function(key, val) {
            box.append(val);
        });
    });
    
    /*  отправка данных формы  */
    $('.snd-btn').on('click', function() {
        let form = $(this).closest('.c-form');
        let $that = $(this);
        let formData = new FormData(form.get(0));

        $.ajax({
            url: 'get_form_data.php',
            type: 'POST',
//            dataType: 'json',
            contentType: false,
            processData: false,
            data: formData,
            success: function(json){
                if(json){
                    let text = '';
                    if(json == 'ok') {
                        text = '<span class="text-success">Комментарий добавлен и будет опубликован после проверки модератором.</span>';
                        clear_form();
                    } else {
                        text = '<span class="text-danger">Ошибка добавления комментария</span>';
                    }
                    $('.inner-msg').html('<h3>' + text + '</h3>');
                    setTimeout(function() {
                        $('.inner-msg').html('')
                        }, 3000);
                }
            }
        });
    });
    
    /* Вход для админа */
    $('.auth').on('click', function() {
        let form = $(
            '<form class="auth-bg">' +
                '<div class="auth-form">' +
                    '<input class="form-control" type="text" name="login" placeholder="Логин" />' +
                    '<input class="form-control" type="text" name="passwd" placeholder="Пароль" />' +
                    '<div class="btn btn-success login-snd">Авторизоваться</div>' +
                    '<div class="auth-close"></div>' +
                '</div>' +
            '</form>'
        );
        
        form.find('.auth-close').on('click', function() {
            close_modal();
        });
        
        form.find('.login-snd').on('click', function() {
            let data = $(this).closest('.auth-bg').serialize();

            $.ajax({
                url: 'auth.php',
                type: 'POST',
                data: data,
                success: function(answ){
                    if(answ){
                        adm_page_view(answ);
                    }
                }
            });
        });
        
        $('body').append(form);
    });
    
    /* выход */
    $('.de-auth').on('click', function() {
        let data = {
            "deauth": 1
        };

        $.ajax({
            url: 'auth.php',
            type: 'POST',
            data: data,
            success: function(answ){
                if(answ){
                    location.reload();
                }
            }
        });
    });
    
    /*  активация комментария админом  */
    $('.fa-eye').on('click', function() {
        let blok = $(this).closest('.comment');
        let id = blok.attr('data-id')

        let data = {
            "action": "activate",
            "id": id
        };

        $.post('controller.php', data, function(answ) {
            console.log(answ);
            if (answ == 'ok') {
                blok.removeClass('on-check');
            } else {
                console.log('Ошибка обновления записи');
            }
        });
    });
    
    /*  выключение комментария админом  */
    $('.fa-eye-slash').on('click', function() {
        let blok = $(this).closest('.comment');
        let id = blok.attr('data-id')

        let data = {
            "action": "lock",
            "id": id
        };

        $.post('controller.php', data, function(answ) {
            console.log(answ);
            if (answ == 'ok') {
                blok.addClass('on-check');
            } else {
                console.log('Ошибка обновления записи');
            }
        });
    });
    
    function clear_form() {
        $('.c-form input, textarea').val('');
    }
    
    function close_modal() {
        $('.auth-bg').remove();
    }
    
    function adm_page_view(answ) {
        if (answ == "verified") {
            location.reload();
        } else {
            close_modal();
        }
    }
    
});