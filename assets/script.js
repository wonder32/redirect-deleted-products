(function($, root) {

    'use strict';

    // the ajax request function
    // page clicked should match the words in all lines with (4)
    function update_redirects(update_array) {
        console.table(update_array);
        $.ajax({
            // we get my_plugin.ajax_url from php, ajax_url was the key the url the value
            url : redirect.ajax_url,
            type : 'post',
            data : {
                // remember_setting should match the last part of the hook (2) in the php file (4)
                action : 'remember_setting',
                nonce  : redirect.nonce,
                update_array : update_array
            },
            // if successfull show the result in the console
            // you could append the outcome in the html of the
            // page
            success : function( response ) {
                console.log(response)
            }
        });

    }

    function setAction(id) {
        $('#action-' + id).html('<div id="update-' + id +'" class="update-button button">Update</div>');
        $(('#row-' + id)).addClass('changed');
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
            setAction(redirectId);
        });

        $("#redirect-deleted-products-table").on("click", ".update-button", function(){
            let updates = [];
            $('#redirect-deleted-products-table tr.changed').each(function (i, row) {
                let $row = $(row);
                let id = $row.find('input.input-redirect').attr('id').replace('redirect-', '');
                let val = $row.find('input.input-redirect').val();
                let status = $row.find('select.redirect').val();
                updates[i] = {id: id, redirect: val, status: status};
            });
            update_redirects(updates);
        });


    });
})(jQuery, this);