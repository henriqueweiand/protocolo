function send(form, options) {
    
    var setup   = {},
        configs = {
            'action'      : '',
            'method'      : "POST",
            'callback'    : false,
            'progressbar' : { element : null, delay   : 2000 }            
        };
    
    if(typeof(options) === "object") $.extend(true, configs, options);

    setup.url = configs.action;
    setup.method = configs.method;
    
    if(form.constructor.name == "FormData" || $(form).prop("tagName") !== undefined) {
        setup.processData = false;
        setup.contentType = false;
        setup.data = form;

        if($(form).prop("tagName") !== undefined){
            setup.method = $(form).attr("method");
            setup.url = $(form).attr("action");
            $(form).attr("enctype", "multipart/form-data");
            setup.data   =  new FormData($(form).get(0));   
        }

    } else if(typeof form == "object")
        setup.data = form;
    else
        setup.data = {};
        
    if(!setup.url.length) {
        console.log("action is not set");
        return false;
    }

    setup.success = function(data) {
        try {
            data = JSON.parse(data);
        } catch (err) {
            json         = data;
            data         = {};
            data.message = json;
            
            if(json == "true")
                data.success = true;
            else
                data.success = false;
        }

        $('#result').html(data.message);

        if(configs.callback) configs.callback.call(this, data);
        if(data.callback) data.callback;

        setTimeout(function(){ $('.sendActivated').removeClass('sendActivated').button('reset'); }, 8000);
    };
    
    if(configs.progressbar != null) {
        $(configs.progressbar).css('display', 'block').find(".progress").slideDown();
    
        setup.xhr = function() {
            var xhr = new window.XMLHttpRequest();
            
            try {
                xhr.upload.addEventListener("progress", function(evt) {
                    if (evt.lengthComputable)
                        $(configs.progressbar).find(".progress-bar").css("width", Math.round(evt.loaded/evt.total*100)+"%");
                }, false);
                
                xhr.onload = function (ev) {
                    $(configs.progressbar).find(".progress").delay(2000).slideUp(function() {
                        $(configs.progressbar).find(".progress-bar").css("width", "0");
                    });
                };

                return xhr;
            }
            catch(err) {}
        };
    }
    
    setup.error = function(data) {
        $('.sendActivated').removeClass('sendActivated').button('reset');
        console.log(data);
    };
    
    try {
        $.ajax(setup);
    } catch(err) {
        console.log(err);
    }
}