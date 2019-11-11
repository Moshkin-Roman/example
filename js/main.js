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
            contentType: false,
            processData: false,
            data: formData,
            success: function(answ){
                if(answ){
                    console.log(answ);
                    let text = '';
                    if(answ == 'ok') {
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
        let data = '';
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
            data = $(this).closest('.auth-bg').serialize();
            send_auth(data);
        });
        
        form.on('keyup', function(event) {
            if (event.keyCode == 13) {
                data = $(this).closest('.auth-bg').serialize();
                send_auth(data);
            } 
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
        let block = $(this).closest('.comment');
        let id = block.attr('data-id')

        let data = {
            "action": "activate",
            "id": id
        };

        $.post('controller.php', data, function(answ) {
            console.log(answ);
            if (answ == 'ok') {
                block.removeClass('on-check');
            } else {
                console.log('Ошибка обновления записи');
            }
        });
    });
    
    /*  выключение комментария админом  */
    $('.fa-eye-slash').on('click', function() {
        let block = $(this).closest('.comment');
        let id = block.attr('data-id')

        let data = {
            "action": "lock",
            "id": id
        };

        $.post('controller.php', data, function(answ) {
            if (answ == 'ok') {
                block.addClass('on-check');
            } else {
                console.log('Ошибка отключения записи');
            }
        });
    });
    
    /*  включение режима редактирования для комментария  */
    $('.fa-pencil-alt').on('click', function() {
        let block = $(this).closest('.comment');
        let text_block = block.find('.comm-text');
        let text = text_block.text();
        let input = $('<input class="comm-edit" />');
        input.val(text);
        text_block.after(input);
        block.addClass('edit');
        
    });
    
    /*  сохранение отредактированного комментария  */
    $('.fa-save').on('click', function() {
        let block = $(this).closest('.comment');
        let id = block.attr('data-id')
        let text_block = block.find('.comm-edit');
        let text = text_block.val();
        text_block.remove();
        
        let data = {
            "action": "save",
            "text": text,
            "id": id
        };

        $.post('controller.php', data, function(answ) {
            if (answ == 'ok') {
                block.find('.comm-text').text(text);
                let mod_info = block.find('.modified');
                if (mod_info.length == 0) {
                    block.find('.comm-text').before('<p class="modified">(изменен администратором)</p>');
                }
            } else {
                console.log('Ошибка обновления записи');
            }
        });
        
        block.removeClass('edit');
    });
    
    function send_auth(data) {
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
    }
    
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