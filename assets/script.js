(function($, root) {

    function setAction(id) {
        $('#action-' + id).html('<div id="update-' + id +'">Update</div>');
    }

    $(document).ready(function() {

        $('.predefined').change(function() {
            let redirectId = $(this).attr('id').replace('select-', '');
            let redirectValue = $(this).attr('value');
            if (redirectValue != 'select') {
                $('#redirect-' + redirectId).val(redirectValue);
                $('#redirect-status-' + redirectId).val('301');
            } else {
                $('#redirect-' + redirectId).val('');
                $('#redirect-status-' + redirectId).val('none');
            }
            setAction(redirectId);
        });

        $('.redirect').change(function() {
            let redirectId = $(this).attr('id').replace('redirect-status-', '');
            let redirectStatusValue = $(this).attr('value');
            if (redirectStatusValue === 'none') {
                $('#redirect-' + redirectId).val('');
                $('#select-' + redirectId).val('select');
            }
            redirectId(redirectId);
        });
    });
})(jQuery, this);