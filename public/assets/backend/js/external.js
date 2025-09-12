$(function () {
    'use strict';
    $('body').on('click', '.action-field', function (e) {   
        setFieldAction();
    });
    setFieldAction();
    if($('.select2').length){
        init_select2();
    }
    if($('.app-image-input').length){
        SetImageInput();
    }
    $('body').on('click', '.app-copy-btn', function (e) {
        clipboard_init($(this));
    });
    if($(".popup-page").length){
        init_popup();
    }
    $("body").on("click", ".close-popup", function(e) {
        e.preventDefault();
        try {
            $('a[data-toggle="image"]').popover('dispose');
            $.magnificPopup.instance.close();
        } catch (e) {}
    });
    $('body').on('click', '.referesh-captcha', function (e) {
        if($.isFunction(window.regenerate_captcha)){
          regenerate_captcha();
        }
    });
    $('body').on('change', '.get-select-data', function (e) {
        var id = $(this).val();
        var tid = $(this).data('target');
        var turl = $(this).data('url');
        var action = $(this).data('action');
        get_select_data(id,tid,turl,action);
    });
    $('body').on('click', '[type=submit]', function (e) {
        e.preventDefault();
        var obj = $(this);
        var form = obj.closest('form');
        if($('.data-parsley-validate').length){
            if (!$(form).parsley().validate()) {
                return false;
            }
        }
        var block_form=$(form).data("block_form");
        var rtype = form.attr("request-type");
        var htmlBeforeLoading = "";
        if (!rtype) { rtype = "json"; }
        var isMultiPart=false;
        if (form.data("multipart")) {
            try {
                form.find("input[type=file]").each(function () {
                    if ($(this).val() != "") {
                       isMultiPart = true;
                   }
               });
            }catch (e){
                isMultiPart=true;
            }
        }
        if (isMultiPart) {
            var formData = new FormData(form[0]);
            formData = set_csrf_param(formData);
            var contentType = false;
            var processData = false;
            var async = true;
        } else {
            var formData = set_csrf_param(form.serialize());
            var contentType = 'application/x-www-form-urlencoded; charset=UTF-8';
            var processData = true;
            var async = true;
        }
        var method = form.attr("method");
        $.ajax({
            type: method,
            url: form.attr('action'),
            data: formData,
            processData: processData,
            dataType: rtype,
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            contentType: contentType,
            cache: false,
            async: async,
            beforeSend: function() {
                on_beforesend(form);
                htmlBeforeLoading = obj.html();
                obj.html('<i class="fa fa-spinner fa-spin"></i>');
                obj.attr("disabled", "disabled");
            },
            success: function(data) {
                show_notification(data.type,data.message,data.title);
                if(data.status){
                    if($('.data-list-table').length){
                        $('.data-list-table').DataTable().ajax.reload(null,false);
                    }
                    if($(".popup-page").length){
                        if($.magnificPopup.instance.isOpen){
                            $.magnificPopup.close();
                        }
                    }
                    if (typeof data.url!= "undefined") {
                        window.location.href = data.url;
                    }
                }
                if($.isFunction(window.regenerate_captcha)){
                    regenerate_captcha();
                }
            },
            complete: function(jqXHR, textStatus) {
                obj.prop('disabled', false).html(htmlBeforeLoading);
                on_complete(form);
                if (jqXHR.status == "500" || jqXHR.status == "403" || textStatus == "error") {
                    show_notification('error',jqXHR.responseJSON.msg, jqXHR.responseJSON.status, jqXHR.responseJSON.title);
                }
            }
        });
    });
    $('body').on('click', '.change-status', function (e) {
        var obj = $(this);
        swal({
           title: "Are You Sure ?",
           type: "warning",
           showCancelButton: true,
           closeOnConfirm: false,
           showLoaderOnConfirm: true
        }, function () {
            $.ajax({
                type: 'POST',
                url: obj.data('url'),
                data: {action:obj.data('action'),id:obj.data('id')},
                processData: true,
                dataType: "json",
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                contentType: 'application/x-www-form-urlencoded; charset=UTF-8',
                cache: false,
                async: true,
                success: function(data) {
                    show_notification(data.type,data.message,data.title);
                    if(data.status){
                        swal.close();
                        if($('.data-list-table').length){
                            $('.data-list-table').DataTable().ajax.reload(null,false);
                        }
                    }
                    
                }
            });
        });
    });
    $('body').on('change', '.change-switch', function (e) { 
        var obj = $(this); 
        var isChecked = obj.is(':checked');
        swal({
           title: "Are You Sure ?",
           type: "warning",
           showCancelButton: true,
           closeOnConfirm: false,
           showLoaderOnConfirm: true
        }, function () {
            $.ajax({
                type: 'POST',
                url: obj.data('url'),
                data: {action:obj.data('action'),id:obj.data('id'),status:isChecked},
                processData: true,
                dataType: "json",
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                contentType: 'application/x-www-form-urlencoded; charset=UTF-8',
                cache: false,
                async: true,
                success: function(data) {
                    show_notification(data.type,data.message,data.title);
                    if(data.status){
                        swal.close();
                        if($('.data-list-table').length){
                            $('.data-list-table').DataTable().ajax.reload(null,false);
                        }
                        if(typeof data.reload!= "undefined"){ 
                            location.reload(); 
                        } 
                    }
                    
                }
            });
        });
    });
    $('body').on('click', '.delete-job', function (e) {
        var obj = $(this);
        swal({
            title: "Are You Sure ?",
            text: "You will not be able to recover this file!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes, delete it!",
            closeOnConfirm: false
         }, function () {
             $.ajax({
                 type: 'POST',
                 url: obj.data('url'),
                 data: {action:obj.data('action'),id:obj.data('id')},
                 processData: true,
                 dataType: "json",
                 headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                 contentType: 'application/x-www-form-urlencoded; charset=UTF-8',
                 cache: false,
                 async: true,
                 success: function(data) {
                     show_notification(data.type,data.message,data.title);
                     if(data.status){
                         swal.close();
                         if($('.data-list-table').length){
                             $('.data-list-table').DataTable().ajax.reload(null,false);
                         }
                     }
                     
                 }
             });
         });
    });
    
    init_images();
    init_tooltip();
});
function init_select2(){
    if($('.select2').length){
        $('.select2').select2();
    }
}
function init_select2modal(){
    if($('.select2-modal').length){
        $('.select2-modal').select2({
            dropdownParent: $('.modal')
        });
    }
}
function init_tooltip(){
    $('[data-toggle="tooltip"]').tooltip();
    $('[data-toggle="tooltip-primary"]').tooltip({
        template: '<div class="tooltip tooltip-primary" role="tooltip"><div class="arrow"><\/div><div class="tooltip-inner"><\/div><\/div>'
    });
    $('[data-toggle="tooltip-secondary"]').tooltip({
        template: '<div class="tooltip tooltip-secondary" role="tooltip"><div class="arrow"><\/div><div class="tooltip-inner"><\/div><\/div>'
    });
    $('[data-toggle="tooltip-info"]').tooltip({
        template: '<div class="tooltip tooltip-info" role="tooltip"><div class="arrow"><\/div><div class="tooltip-inner"><\/div><\/div>'
    });
    $('[data-toggle="tooltip-danger"]').tooltip({
        template: '<div class="tooltip tooltip-danger" role="tooltip"><div class="arrow"><\/div><div class="tooltip-inner"><\/div><\/div>'
    });
    $('[data-toggle="tooltip-success"]').tooltip({
        template: '<div class="tooltip tooltip-success" role="tooltip"><div class="arrow"><\/div><div class="tooltip-inner"><\/div><\/div>'
    });
    $('[data-toggle="tooltip-warning"]').tooltip({
        template: '<div class="tooltip tooltip-warning" role="tooltip"><div class="arrow"><\/div><div class="tooltip-inner"><\/div><\/div>'
    });
}
function init_images(){
    $('body').find('.image-delay').each(function(){
        var src = $(this).data('src');
        if($(this).is('img')){
            $(this).attr('src',src);
        } else {
            $(this).css('background-image',"url('"+src+"')");
        } 
    });
}
function init_popup(){
    $(".popup-page").magnificPopup({
        type: 'ajax',
        preloader: true,
        removalDelay: 500,
        closeOnBgClick: false,
        closeBtnInside: true,
        overflowY: 'auto',
        fixedBgPos: false,
        zoom: { enabled: false },
        showCloseBtn:false,
        tLoading: '<i class="fa fa-circle-o faa-burst animated"></i> &nbsp;Loading..',
        callbacks: {
            beforeOpen: function() {},
            open: function() {},
            close: function() {},
            updateStatus: function(data) {
                if (data.status === 'ready') {
                    SetImageInput();
                    init_images();
                    /*set_summernote_init();
                    reload_feather();
                    /*_popupajaxLoadComplted();*/
                }
            }
        }
    });
}
function initDatatableOptions() {
    init_popup();
    init_tooltip();
    init_images();
}
function init_select2(){
    if($('.select2').length){
        $('.select2').select2();
    }
    if($('.select2-modal').length){
        $('.select2-modal').select2({
            dropdownParent: $('.modal')
        });
    }
}
function clipboard_init(obj){
    var text = obj.data('clipboard-text');
    if(text!=''){
        ClipboardJS.copy(text);
        show_notification('success', '<small>'+text+'</small>', 'Copied', icon="clipboard");
    }
}
function setFieldAction(){
    if($('.action-field').length){
        var action = $(".action-field:checked").data('action');
        if($('.'+action+'-action').length){
            if($('.action-fld').length){
                $('.action-fld').each(function(){
                    if($(this).hasClass(action+'-action')){
                        $(this).prop('required',true);
                        $(this).prop("disabled",false);
                    }else{
                        $(this).removeAttr('required');
                        $(this).prop("disabled",true);
                    }
                });
            }
            if($('.action-dv').length){
                $('.action-dv').each(function(){
                    if($(this).hasClass(action+'-action-dv')){
                        $(this).show();
                    }else{
                        $(this).hide();
                    }
                });
            }
        }
    }
}
function on_beforesend(form){ 
    //form.find(">.card").addClass("state-loading");
    form.addClass("state-loading");
}  
function on_complete(form){
    //form.find(">.card").removeClass("state-loading");
    form.removeClass("state-loading");
}
function show_notification(type, msg, title, icon="times-circle-o", IsSticky=true) {
    if(type=='success'){
        icon="check-circle-o";
    }
    var options = {
        title: title,
        style: type,
        theme: 'right-bottom.css',
        timeout: 5000,
        message: msg,
        icon: icon,
        multiline: true
    };
    if (!IsSticky) {
        options.timeout = null;
    }
    var n = new notify(options);
    n.show();
}
function set_csrf_param(param) {  
    /*var postValue = getCookie(csrf_ajax_cookie_name);
    if (postValue && postValue != "") {
        if (typeof param == "string") {
            if (param != "") {
                param += "&";
            }
            param += csrf_ajax_input_name + "=" + postValue;
        } else if (typeof param == "object") {
            try {
                if (typeof param.append === 'function') {
                    param.append(csrf_ajax_input_name, postValue);
                } else {
                  if(param.length==0){
                         param[csrf_ajax_input_name]=postValue;
                  }else{                    
                         param[csrf_ajax_input_name]=postValue;
                  }
                }
            } catch (e) {}

        }
    }*/
    return param;
}
function SetImageInput() {
    var fileCounter = 0;
    $(".app-image-input:not(.added-apim)").each(function() {
        try {
            fileCounter++;
            var mainObj = $(this);
            mainObj.addClass("added-apim");
            var on_change=mainObj.data("change");
            if(on_change){
                on_change=eval(on_change);
            }
            var has_delete=mainObj.data("delete");
            
            var imgObj = null
            var imgObjstr = mainObj.data("img-id");
            if (imgObjstr) {
                imgObj = $(imgObjstr);
            } else {
                imgObj = mainObj;
            }
            var inputname = mainObj.data("name");
            if (!inputname || inputname == "") {
                inputname = "file_" + fileCounter;
            }
            var inputObj = $('<input type="file" name="' + inputname + '" style="display:none;" accept="image/*">');
            var delete_btn=null;
            if(has_delete){               
                delete_btn=$('<button style="display:none;position: absolute;right: 16px;top: 6px;font-size: 9px;" class="btn btn-danger btn-xs"><fa class="fa-trash"></fa></button>');  
                delete_btn.click(function(e){
                    e.preventDefault();
                    inputObj.val("");
                    var noimg=mainObj.data("date-noimage");
                    if(!noimg){
                        noimg=uploads_url+"default.png";
                    }
                    mainObj.attr("src",noimg);
                    $(this).hide();
                    try{
                        if(typeof on_change == "function"){
                            on_change("");                            
                        }
                    }catch(e){ }
                });
                if(mainObj.data("show-delete")){
                    delete_btn.show();
                }
                mainObj.after(delete_btn);
            }
            mainObj.on("click", function() {
                inputObj.trigger('click');
            });
            inputObj.on("change", function(e) {
                var fr = new FileReader();
                /*when image is loaded, set the src of the image where you want to display it*/
                fr.onload = function(e) {
                    imgObj.attr("src", this.result);
                    mainObj.after(inputObj);
                    try{
                        if(delete_btn){
                            delete_btn.show();
                        }
                    }catch(e){}
                    try{
                        gcl(on_change);
                        if(typeof on_change == "function"){
                            on_change(this.result);
                        }
                    }catch(e){ }
                };
                fr.readAsDataURL(this.files[0]);
            });
        } catch (e) {
            gcl(e.message);
        }
    });
}
function get_select_data(id,tid,turl,action){
    $.ajax({
        type: 'POST',
        url: turl,
        data: {action : action, id : id},
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        beforeSend: function () { },
        success: function (data) {
            show_notification(data.type,data.message,data.title);
            /*var html = ''; $(data.details).each(function(key,value){ html += '<option value="'+value.id+'">'+value.text+'</option>'; }); $(tid).html(html);*/
            $(tid).select2('destroy').empty().select2({ data: data.details });
            $(tid).val("").trigger("change");
            init_select2modal();
        },
        error: function (xhr) { },
        complete: function () { }
    });
}