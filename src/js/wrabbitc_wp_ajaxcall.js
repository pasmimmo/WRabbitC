console.log("wrabbitc_wp_ajaxcall loaded");

jQuery(document).ready(function($) {
    $body = $("body");
    var request;
    $("#wrabbit_request_form").submit(function (event) {
        // Prevent default posting of form - put here to work in case of errors
        event.preventDefault();
        // Abort any pending request
        if (request) {
            request.abort();
        }
        // setup some local variables
        var name = $('#wrabbitc_name').val();
        var email = $('#wrabbitc_email').val();
        var proteins = encodeURIComponent($('#wrabbitc_proteins').val());
        var Adata = {
            action: 'wrabbitc_send_message',
            security : Wrabbit.security,
            name : name,
            email : email,
            proteins: proteins
    };
    // Let's disable the inputs for the duration of the Ajax request.
    //$inputs.prop("disabled", true);
    // Fire off the request to encoded url  Wrabbit.ajaxurl
    request = $.ajax({
        url: Wrabbit.ajaxurl,
        type: "post",
        data: Adata
    });
    request.done(function (response) {
        alert(response);
    });
})
});
jQuery(document).on({
    ajaxStart: function() { $body.addClass("loading");    },
     ajaxStop: function() { $body.removeClass("loading"); }    
});