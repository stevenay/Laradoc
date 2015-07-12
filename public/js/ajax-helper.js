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