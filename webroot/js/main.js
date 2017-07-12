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

















maintainHeight = function(){
    var mainHolder = document.getElementById("main-image-container");
    var imgTagWrapperId = document.getElementById("imgTagWrapperId");
    if(mainHolder && typeof mainHolder != 'undefined'){
        var ratio = 0.84;
        var shouldAutoPlay = false;
        var naturalMainImageSize = false;
        var videoSizes = [[250, 445], [281, 500], [309, 550], [341, 606], [382, 679]];
        
        
        var width = mainHolder.offsetWidth;
        var containerHeight = width/ratio;
        containerHeight = Math.min(containerHeight, 700);
        var aspectRatio = 382/679

        var landingImage = document.getElementById("landingImage");

        var imageHeight = containerHeight;
        var imageWidth = width;

        if(!shouldAutoPlay) {
            imageHeight = Math.min(imageHeight, 679);
            imageWidth = Math.min(imageWidth, 382);
        }

        
        var imageWidthBasedOnHeight = imageHeight * aspectRatio;
        var imageHeightBasedOnWidth = imageWidth / aspectRatio;

        imageHeight = Math.min(imageHeight, imageHeightBasedOnWidth);
        imageWidth = Math.min(imageWidth, imageWidthBasedOnHeight);

        if(typeof mainImgMaxHeight !== 'undefined' && mainImgMaxHeight){ 
            containerHeight = Math.min(mainImgMaxHeight, containerHeight);
        }

        mainHolder.style.height = containerHeight + "px";
        if(imgTagWrapperId && typeof imgTagWrapperId !== 'undefined' ){
            imgTagWrapperId.style.height = containerHeight + "px";
        }
        if(landingImage && !naturalMainImageSize) {
            landingImage.style.maxHeight = imageHeight + "px";
            landingImage.style.maxWidth  = imageWidth + "px";
        }
        if(shouldAutoPlay){
            if(landingImage){
                landingImage.style.height = imageHeight + "px";
                landingImage.style.width  = imageWidth + "px";
            }
        }
    }
};
maintainHeight();

window.onresize = function(){
    maintainHeight();
};



P.when('A').register("ImageBlockATF", function(A){
    var data = {
        'colorImages': {
            'initial': [
                {
                    "hiRes":"https://images-na.ssl-images-amazon.com/images/I/71biaOewLFL._UL1500_.jpg",
                    "thumb":"https://images-na.ssl-images-amazon.com/images/I/41ahDMCVVbL._SR38,50_.jpg",
                    "large":"https://images-na.ssl-images-amazon.com/images/I/41ahDMCVVbL.jpg",
                    "main": {
                        "https://images-na.ssl-images-amazon.com/images/I/71biaOewLFL._UY445_.jpg":[445,251],
                        "https://images-na.ssl-images-amazon.com/images/I/71biaOewLFL._UY500_.jpg":[500,282],
                        "https://images-na.ssl-images-amazon.com/images/I/71biaOewLFL._UY550_.jpg":[550,310],
                        "https://images-na.ssl-images-amazon.com/images/I/71biaOewLFL._UY606_.jpg":[606,341],
                        "https://images-na.ssl-images-amazon.com/images/I/71biaOewLFL._UY679_.jpg":[679,383]
                    },
                    "variant":"MAIN",
                    "lowRes":null
                },
                {
                    "hiRes":"https://images-na.ssl-images-amazon.com/images/I/71T7YX0GwbL._UL1500_.jpg",
                    "thumb":"https://images-na.ssl-images-amazon.com/images/I/51xZ28WFxnL._SR38,50_.jpg",
                    "large":"https://images-na.ssl-images-amazon.com/images/I/51xZ28WFxnL.jpg",
                    "main":{
                        "https://images-na.ssl-images-amazon.com/images/I/71T7YX0GwbL._UX342_.jpg":[365,342],
                        "https://images-na.ssl-images-amazon.com/images/I/71T7YX0GwbL._UX385_.jpg":[411,385],
                        "https://images-na.ssl-images-amazon.com/images/I/71T7YX0GwbL._UX425_.jpg":[454,425],
                        "https://images-na.ssl-images-amazon.com/images/I/71T7YX0GwbL._UX466_.jpg":[497,466],
                        "https://images-na.ssl-images-amazon.com/images/I/71T7YX0GwbL._UX522_.jpg":[557,522]
                    },
                    "variant":"PT01",
                    "lowRes":null
                },
                {
                    "hiRes":"https://images-na.ssl-images-amazon.com/images/I/61DPjf34NqL._UL1500_.jpg",
                    "thumb":"https://images-na.ssl-images-amazon.com/images/I/41w9njPV4YL._SR38,50_.jpg",
                    "large":"https://images-na.ssl-images-amazon.com/images/I/41w9njPV4YL.jpg",
                    "main":{
                        "https://images-na.ssl-images-amazon.com/images/I/61DPjf34NqL._UX342_.jpg":[340,342],
                        "https://images-na.ssl-images-amazon.com/images/I/61DPjf34NqL._UX385_.jpg":[382,385],
                        "https://images-na.ssl-images-amazon.com/images/I/61DPjf34NqL._UX425_.jpg":[422,425],
                        "https://images-na.ssl-images-amazon.com/images/I/61DPjf34NqL._UX466_.jpg":[463,466],
                        "https://images-na.ssl-images-amazon.com/images/I/61DPjf34NqL._UX522_.jpg":[518,522]
                    },
                    "variant":"PT02",
                    "lowRes":null
                },
                {
                    "hiRes":"https://images-na.ssl-images-amazon.com/images/I/61Oim5jse%2BL._UL1500_.jpg",
                    "thumb":"https://images-na.ssl-images-amazon.com/images/I/21EVAPTIqVL._SR38,50_.jpg",
                    "large":"https://images-na.ssl-images-amazon.com/images/I/21EVAPTIqVL.jpg",
                    "main":{
                        "https://images-na.ssl-images-amazon.com/images/I/61Oim5jse%2BL._UX342_.jpg":[109,342],
                        "https://images-na.ssl-images-amazon.com/images/I/61Oim5jse%2BL._UX385_.jpg":[123,385],
                        "https://images-na.ssl-images-amazon.com/images/I/61Oim5jse%2BL._UX425_.jpg":[136,425],
                        "https://images-na.ssl-images-amazon.com/images/I/61Oim5jse%2BL._UX466_.jpg":[149,466],
                        "https://images-na.ssl-images-amazon.com/images/I/61Oim5jse%2BL._UX522_.jpg":[167,522]
                    },
                    "variant":"PT05",
                    "lowRes":null
                }
            ]
        },
                    'colorToAsin': {'initial': {}},
        'heroImage': {'initial': []},
        'heroVideo': {'initial': []},
        'holderRatio': 0.84,
        'holderMaxHeight': 700,
        'useStretchyImageFix': true,
        'isEnhancedImageBlockSize' : false,
        'extraVideos' : []
};
    A.trigger('P.AboveTheFold'); // trigger ATF event.
    return data;
});

