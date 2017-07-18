"use strict";
$(function () {

});

var TOKEN_FIELDS = ['_method', '_csrfToken', '_Token[fields]', '_Token[unlocked]', '_Token[debug]'];

function switchMode(mode, target) {
    var blocks = {};

    if (target === undefined) {
        blocks.view = $("#block-view, .block-view");
        blocks.input = $("#block-input, .block-input");
    } else {
        blocks.view = $(target).find("#block-view, .block-view");
        blocks.input = $(target).find("#block-input, .block-input");
    }

    switch (mode) {
        case 'view':
            blocks.view.show();
            blocks.input.hide();
            break;
        case 'input':
            blocks.input.show();
            blocks.view.hide();
            break;
    }
}

function resetForm(form, fields) {
    if (fields === undefined) {
        $.each($(form).serializeArray(), function (index, object) {
            if ($.inArray(object.name, TOKEN_FIELDS) === -1) {
                var field = $(form).find("[name='" + object.name + "']");
                switch (field.attr('type')) {
                    case 'radio':
                        field.filter("[value='" + field.data('default') + "']").prop('checked', true);
                        break;
                    case 'checkbox':
                        break;
                    default:
                        field.val(field.data('default'))
                }
            }
        })
    } else {
        $.each(fields, function (name, callback) {
            if ($.isFunction(callback)) {
                callback()
            } else {
                var field = $(form).find("[name='" + name + "']");
                field.val(field.data('default'))
            }
        })
    }
}

function clearValidationErrors(form, fields) {
    if (form === undefined) {
        form = $('body');
    }

    if (fields === undefined) {
        $(form).find('.validation-error').remove()
    } else {
        $.each(fields, function (index, name) {
            $(form).find('#validation-' + name + '.validation-error').remove()
        })
    }
}



var a = [
    {
        "mainUrl":"https://images-na.ssl-images-amazon.com/images/I/91f9Uhj1HhL.jpg",
        "dimensions":[1768,2508],
        "thumbUrl":"https://images-na.ssl-images-amazon.com/images/I/91f9Uhj1HhL._AC_SX75_CR,0,0,75,75_.jpg"
    },
    {
        "mainUrl":"https://images-na.ssl-images-amazon.com/images/I/51iBg6YNfvL.jpg",
        "dimensions":[337,500],
        "thumbUrl":"https://images-na.ssl-images-amazon.com/images/I/51iBg6YNfvL._AC_SX75_CR,0,0,75,75_.jpg"
    }
        ]

