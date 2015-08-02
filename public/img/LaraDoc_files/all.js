/* jQuery Tiny Pub/Sub - v0.7 - 10/27/2011
 * http://benalman.com/
 * Copyright (c) 2011 "Cowboy" Ben Alman; Licensed MIT, GPL */

(function($) {

    var o = $({});

    $.subscribe = function() {
        o.on.apply(o, arguments);
    };

    $.unsubscribe = function() {
        o.off.apply(o, arguments);
    };

    $.publish = function() {
        o.trigger.apply(o, arguments);
    };

}(jQuery));
(function() {

    var submitAjaxRequest = function(e) {
        var form = $(this);
        var method = form.find('input[name="_method"]').val() || 'POST';

        var delButton = form.find('input[type="Submit"]');
        var updLink = form.closest('td').prev().find('a');

        var deleteHtml = "<span class='text-danger'><strong><span class='glyphicon glyphicon-ok'></span>&nbsp;deleted</strong></span>";

        $.ajax({
            headers: { 'X-CSRF-Token': form.find('input[name="_token"]').val() },
            type: method,
            url: form.prop('action'),
            data: form.serialize(),
            success: function() {
                $.publish('form.submitted', form);
                updLink.hide();
                delButton.hide();
                delButton.closest('div[class="form-group"]').append(deleteHtml);
            }
        });

        e.preventDefault();
    }

    $('form[data-remote]').on('submit', submitAjaxRequest);

})();
(function() {

    $.subscribe('form.submitted', function() {
        $('.flash').fadeIn(500).delay(1000).fadeOut(500);
    });

})();