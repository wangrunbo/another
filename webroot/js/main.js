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

//>>>>>>>>

P.when('A').register("ImageBlockATF", function(A){
    var data = {
    'colorImages': {
        'initial': [
            {
                "hiRes":"https://images-na.ssl-images-amazon.com/images/I/91CFY6xXaoL._SL1500_.jpg",
                "thumb":"https://images-na.ssl-images-amazon.com/images/I/51wujazh-EL._SX38_SY50_CR,0,0,38,50_.jpg",
                "large":"https://images-na.ssl-images-amazon.com/images/I/51wujazh-EL.jpg",
                "main":{
                    "https://images-na.ssl-images-amazon.com/images/I/91CFY6xXaoL._SX342_.jpg":[171,342],
                    "https://images-na.ssl-images-amazon.com/images/I/91CFY6xXaoL._SX385_.jpg":[193,385],
                    "https://images-na.ssl-images-amazon.com/images/I/91CFY6xXaoL._SX425_.jpg":[213,425],
                    "https://images-na.ssl-images-amazon.com/images/I/91CFY6xXaoL._SX466_.jpg":[233,466],
                    "https://images-na.ssl-images-amazon.com/images/I/91CFY6xXaoL._SX522_.jpg":[261,522]
                },
                "variant":"MAIN",
                "lowRes":null
            },
            {
                "hiRes":null,
                "thumb":"https://images-na.ssl-images-amazon.com/images/I/51pAXJePOgL._SX38_SY50_CR,0,0,38,50_.jpg",
                "large":"https://images-na.ssl-images-amazon.com/images/I/51pAXJePOgL.jpg",
                "main":
                    {
                        "https://images-na.ssl-images-amazon.com/images/I/51pAXJePOgL._SX342_.jpg":[282,342],
                        "https://images-na.ssl-images-amazon.com/images/I/51pAXJePOgL._SX385_.jpg":[318,385],
                        "https://images-na.ssl-images-amazon.com/images/I/51pAXJePOgL._SX425_.jpg":[351,425],
                        "https://images-na.ssl-images-amazon.com/images/I/51pAXJePOgL._SX466_.jpg":[385,466],
                        "https://images-na.ssl-images-amazon.com/images/I/51pAXJePOgL.jpg":[413,500]
                    },
                "variant":"PT02",
                "lowRes":null
            },
            {
                "hiRes":null,
                "thumb":"https://images-na.ssl-images-amazon.com/images/I/51lU6lDAYkL._SX38_SY50_CR,0,0,38,50_.jpg",
                "large":"https://images-na.ssl-images-amazon.com/images/I/51lU6lDAYkL.jpg",
                "main":{
                    "https://images-na.ssl-images-amazon.com/images/I/51lU6lDAYkL._SX342_.jpg":[333,342],
                    "https://images-na.ssl-images-amazon.com/images/I/51lU6lDAYkL._SX385_.jpg":[375,385],
                    "https://images-na.ssl-images-amazon.com/images/I/51lU6lDAYkL._SX425_.jpg":[414,425],
                    "https://images-na.ssl-images-amazon.com/images/I/51lU6lDAYkL._SX466_.jpg":[454,466],
                    "https://images-na.ssl-images-amazon.com/images/I/51lU6lDAYkL.jpg":[487,500]
                },
                "variant":"PT03","lowRes":null
            },
            {
                "hiRes":"https://images-na.ssl-images-amazon.com/images/I/814HyjOZYvL._SL1500_.jpg",
                "thumb":"https://images-na.ssl-images-amazon.com/images/I/41w3UAHT1iL._SX38_SY50_CR,0,0,38,50_.jpg",
                "large":"https://images-na.ssl-images-amazon.com/images/I/41w3UAHT1iL.jpg",
                "main":{
                    "https://images-na.ssl-images-amazon.com/images/I/814HyjOZYvL._SX342_.jpg":[328,342],
                    "https://images-na.ssl-images-amazon.com/images/I/814HyjOZYvL._SX385_.jpg":[370,385],
                    "https://images-na.ssl-images-amazon.com/images/I/814HyjOZYvL._SX425_.jpg":[408,425],
                    "https://images-na.ssl-images-amazon.com/images/I/814HyjOZYvL._SX466_.jpg":[447,466],
                    "https://images-na.ssl-images-amazon.com/images/I/814HyjOZYvL._SX522_.jpg":[501,522]
                },
                "variant":"PT04","lowRes":null
            },
            {
                "hiRes":null,
                "thumb":"https://images-na.ssl-images-amazon.com/images/I/61XJYDXM%2BlL._SX38_SY50_CR,0,0,38,50_.jpg",
                "large":"https://images-na.ssl-images-amazon.com/images/I/61XJYDXM%2BlL.jpg",
                "main":{
                    "https://images-na.ssl-images-amazon.com/images/I/61XJYDXM%2BlL._SX342_.jpg":[342,342],
                    "https://images-na.ssl-images-amazon.com/images/I/61XJYDXM%2BlL._SX385_.jpg":[385,385],
                    "https://images-na.ssl-images-amazon.com/images/I/61XJYDXM%2BlL._SX425_.jpg":[425,425],
                    "https://images-na.ssl-images-amazon.com/images/I/61XJYDXM%2BlL._SX466_.jpg":[466,466],
                    "https://images-na.ssl-images-amazon.com/images/I/61XJYDXM%2BlL.jpg":[500,500]
                },
                "variant":"PT05",
                "lowRes":null
            },
            {
                "hiRes":null,
                "thumb":"https://images-na.ssl-images-amazon.com/images/I/51YALymaiAL._SX38_SY50_CR,0,0,38,50_.jpg",
                "large":"https://images-na.ssl-images-amazon.com/images/I/51YALymaiAL.jpg",
                "main":{
                    "https://images-na.ssl-images-amazon.com/images/I/51YALymaiAL._SX342_.jpg":[342,342],
                    "https://images-na.ssl-images-amazon.com/images/I/51YALymaiAL._SX385_.jpg":[385,385],
                    "https://images-na.ssl-images-amazon.com/images/I/51YALymaiAL._SX425_.jpg":[425,425],
                    "https://images-na.ssl-images-amazon.com/images/I/51YALymaiAL._SX466_.jpg":[466,466],
                    "https://images-na.ssl-images-amazon.com/images/I/51YALymaiAL.jpg":[500,500]
                },
                "variant":"PT06",
                "lowRes":null
            },
            {
                "hiRes":"https://images-na.ssl-images-amazon.com/images/I/91WYEDUj5DL._SL1500_.jpg",
                "thumb":"https://images-na.ssl-images-amazon.com/images/I/51COt0XjY4L._SX38_SY50_CR,0,0,38,50_.jpg",
                "large":"https://images-na.ssl-images-amazon.com/images/I/51COt0XjY4L.jpg",
                "main":{
                    "https://images-na.ssl-images-amazon.com/images/I/91WYEDUj5DL._SX342_.jpg":[228,342],
                    "https://images-na.ssl-images-amazon.com/images/I/91WYEDUj5DL._SX385_.jpg":[257,385],
                    "https://images-na.ssl-images-amazon.com/images/I/91WYEDUj5DL._SX425_.jpg":[283,425],
                    "https://images-na.ssl-images-amazon.com/images/I/91WYEDUj5DL._SX466_.jpg":[311,466],
                    "https://images-na.ssl-images-amazon.com/images/I/91WYEDUj5DL._SX522_.jpg":[348,522]
                },
                "variant":"PT07",
                "lowRes":null
            }
        ]
    },
                'colorToAsin': {'initial': {}},
    'holderRatio': 0.77,
    'holderMaxHeight': 700,
    'heroImage': {'initial': []},
    'heroVideo': {'initial': []},
    'weblabs' : {}
};
    A.trigger('P.AboveTheFold'); // trigger ATF event.
    return data;
});

