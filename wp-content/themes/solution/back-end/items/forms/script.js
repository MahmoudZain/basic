$(document).on('click', '.delete_media', function (e) {
    confirm('Do you want to delete this image ?')
    {
        ajaxurl = 'admin-ajax.php';
        var data = {
            action: 'delete_media',
            media_id: $(this).attr('id')
        };
        $.ajax({
            type: "POST",
            url: ajaxurl,
            data: data,
            success: function (response) {
                $('#' + data.media_id).parent('div').remove();
            },
            error: function (errorThrown) {
                alert(errorThrown);
            }
        });
    }
});