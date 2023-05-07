$(document).bind("ajaxSend", function(event, jqXHR, options){
    jqXHR.setRequestHeader('X-CSRF-TOKEN', window.Laravel.csrfToken);
});