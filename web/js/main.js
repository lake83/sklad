jQuery(document).ready(function () {
    // выделение активного пункта меню
    $('.ZTmiddle a').each(function(){
        if ($(this).attr('href') == location.pathname) {
            $(this).addClass('active');
        }
    });
    //кнопка Наверх
    $(window).scroll(function() {
        if ($(this).scrollTop() != 0) {
            $('#toTop').fadeIn();
        } else { 
            $('#toTop').fadeOut(); 
        } 
    });
    $('#toTop').click(function() {
        $('body,html').animate({scrollTop:0},800);
    });
    // смена региона
    $('#download_now').click(function() {
        $('#region-list').toggle();
    });
    // меню каталога
    $('.cat-modal').hover(
         function () {
             $(this).find('ul:first').addClass('cat-preview').toggle();
         }, function () {
             $(this).find('ul:first').removeClass('cat-preview').toggle();
         }
    );
    
    // работа с формами
    $('#recall-form, #get-pricelist, #have-question').on('beforeSubmit', function(e) {
        var form = $(this), formData = form.serialize(), modal = $('#' + form.attr('id') + '-modal .modal-body');
        $.ajax({
            url: form.attr('action'),
            type: form.attr('method'),
            data: formData,
            success: function (data) {
                form[0].reset();
                if (form.attr('id') == 'have-question') {
                    $('#have-question-modal').modal();
                }
                modal.html(data.message);
            },
            error: function () {
                modal.html('Не удалось отправить сообщение.');
            }
        });
    }).on('submit', function(e){
        e.preventDefault();
    });
});