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
        let data = $(this).closest('.c-form');
        let $that = $(this);
        let formData = new FormData(data.get(0));

        $.ajax({
            url: 'get_form_data.php',
            type: 'POST',
//            dataType: 'json',
            contentType: false,
            processData: false,
            data: formData,
            success: function(json){
                if(json){
                    console.log(json);
                }
            }
        });
    });
    
});