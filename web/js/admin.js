// Редактирование и создание настроек
$('body').on('beforeSubmit', '#paramForm, #createSettingForm', function () {
    var form = $(this);
    if (form.find('.has-error').length) {
        return false;
    }
    $.ajax({
        url: form.attr('action'),
        type: 'post',
        data: form.serialize(),
        success: function(data){ 
            if (form.attr('id') == 'paramForm') {
                if (data.name == 'skin') {
                    location.reload();
                } else {
                    $('#modalContent').html(data.message);$('#' + data.name).text(data.value);
                }
            } else {
                $('#modalContent').html(data);
            } 
        }
    });
    return false;
});
function settings(label,field,url){
    $.ajax({
       type: 'POST',
       cache: false,
       url: url,
       data: {field: field},
       success: function(data) {
           $('#modalContent').html(data);
           $('#modal').modal('show').find('#modalTitle').text(label);
       }
    });
}
function createSetting(title,url){
    $.ajax({
       type: 'POST',
       cache: false,
       url: url,
       success: function(data) {
           $('#modalContent').html(data);
           $('#modal').modal('show').find('#modalTitle').text(title);
       }
    });
}

// вывод диалога confirm в стиле bootstrap
yii.confirm = function (message, ok, cancel) {
    krajeeDialog.confirm(message, function (confirmed) {
        if (confirmed) {
            !ok || ok();
        } else {
            !cancel || cancel();
        }
    });
    return false;
}

// переключение типа пункта меню
$('#menuitems-type').on('change', function() {
    if (this.value == 1) {
        $('#type-list').css('display', 'block').find('select').attr('disabled', false).val('');
        $('#type-input').css('display', 'none').find('input').attr('disabled', true);
    } else {
        $('#type-input').css('display', 'block').find('input').attr('disabled', false).val('');
        $('#type-list').css('display', 'none').find('select').attr('disabled', true);
    }
});

// получение связанных товаров
$('#catalog-related').on('change', function() {
    $.ajax({
       type: 'POST',
       cache: false,
       url: $(this).parents('form').attr('action'),
       data: {catalog_id: $(this).val()},
       success: function(data) {
           if (jQuery.type(data) === "string") {
               $('#products-related-inner').hide();
               $('#no_products').html(data);
           } else {
               $('#no_products').html('');
               $('#products-select').multiselect({nonSelectedText: 'Выберите товары', includeSelectAllOption: false});
               $('#products-select').multiselect('dataprovider', data);
               $('#products-related-inner').show();
           }
       }
    });
});

// вывод названия брошюр
$('.container-items-brochures .file-name').each(function() {
    $(this).html('<b>' + $(this).text() + '</b><br />' + $(this).data('file')); 
});