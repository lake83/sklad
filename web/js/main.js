jQuery(document).ready(function () {
    // выделение активного пункта меню
    $('.ZTmiddle a').each(function(){
        if ($(this).attr('href') == location.pathname) {
            $(this).addClass('active');
        }
    });
});