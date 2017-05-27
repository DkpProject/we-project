function SwitchEnable(elements, onText = "Да", offText = "Нет", stylerDestroy = true) {
    $.each(elements, function( index, value ) {
        if (stylerDestroy) {
            $(value).styler('destroy');
        }
        $(value).bootstrapSwitch({onText: onText, offText: offText}).on("switchChange.bootstrapSwitch", function() {
            $(this).trigger("changeValue");
        });
    });
}

function StylerEnable(elements) {
    elements.styler({
        selectSearch: true
    });
}

function GalleryEnable(elements) {
    elements.lightGallery();
}

function SlideEnable(elements) {
    elements.slick({
        infinite: true,
        slidesToShow: 3,
        centerMode: true,
        variableWidth: true
    });
}

function ColorEnable(elemants) {
    elemants.colorpicker().on('changeColor', function(ev){
        $(this).next().children().css("backgroundColor", ev.color);
        $(this).trigger("changeValue");
    });
}

function SliderEnable(elements, min = 1, max = 15, start = 5, step = 0.1) {
    $.each(elements, function( index, value ) {
        noUiSlider.create(value, {
            start: start,
            connect: 'lower',
            tooltips: true,
            range: {
                'min':  min,
                'max':  max
            },
            step: step
        });
        value.noUiSlider.on('update', function( values, handle ) {
            $(value).next().val(values[handle]);
            $(value).next().trigger("changeValue");
        });
    });
}

function DateTimeEnable(elements, time) {
    time = (time==undefined)?true:time;
    var format = (time)?'DD / MM / YYYY HH:mm':'DD / MM / YYYY';
    elements.datetimepicker({
        format: format,
        language: 'ru',
        pickTime: time
    });
}

function SendFormEnable(typeAction, responseCallback) {
    $(".form-send").on("submit", function(e) {
        e.preventDefault();
        var formData = new FormData();
        formData.append("typeAction", typeAction);
        $.each($(this).find(".input-send"), function(key, val) {
            if ($(val).attr('name') == undefined) return;
            if ($(val).attr('type') == "checkbox" || $(val).attr('type') == "radio") {
                if ($(val).is(":checked")) {
                    formData.append($(val).attr('name'), 1);
                } else {
                    formData.append($(val).attr('name'), 0);
                }
            } else if($(val).attr('type') == "file") {
                $.each(val.files, function(k, v) {
                    formData.append($(val).attr('name'), v);
                });
            } else {
                formData.append($(val).attr('name'), $(val).val());
            }
        });
        $.ajax({url: $(this).attr('action'), type: "POST", processData: false, contentType: false, data: formData, success: function (data){
            responseCallback(data);
        }
        });
    });
}

$( document ).ready(function() {
    $('.fa-plus.photo-add').click(function () {
        if (photos < 5) {
            $('div#photo-styler:last').after('<br><input class="styler inserted-input" type="file" name="photo[]" id="photo">');
            console.log($('input.inserted-input:last').styler());
            $('input:last').styler();
            photos++;
        }
        if (photos == 5) {
            $(this).addClass('hide');
        }
    });
    $('[data-toggle="tooltip"]').tooltip();
    $('input:not([type=radio]):not([type=checkbox])').styler();
    $("input[name='birthday']").mask("99 / 99 / 9999");
    $("input.datetimepick").mask("99 / 99 / 9999 99:99");
    $("input[name='phone']").mask("+9(999)999-99-99");
    $("select").select2({
        theme: "bootstrap",
        lang: "ru"
    });
});