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
});