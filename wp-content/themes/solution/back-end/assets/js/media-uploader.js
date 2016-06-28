/**
 * Created by ZAIN on 3/31/2016.
 */
function upload_img() {
    var media_frame;
    if (media_frame) {
        media_frame.open();
        return;
    }
    media_frame = wp.media.frames.media_frame = wp.media({
        frame: 'select',
        multiple: true,
        title: "Upload Images",
        library: {
            type: 'image'
        },
        button: {
            text: "Choose Images"
        }
    });
    media_frame.on('select', function () {
        var media_attachment = media_frame.state().get('selection').toJSON();
        $.each(media_attachment, function (index, element) {
            $('.media_holder').append('<div><img class="img_preview" style="display:block" src="' + element.url + '"/><input type="button" value="Delete" class="delete-button delete_img"><input class="img_url" type="text" name="media_url[]" placeholder="Image Url" readonly value="' + element.url + '"/><input type="button" value="change Image" class="change_img"></div>');
        });
    });
    media_frame.open();
}
function upload_featured() {
    var media_frame;
    if (media_frame) {
        media_frame.open();
        return;
    }
    media_frame = wp.media.frames.media_frame = wp.media({
        frame: 'select',
        multiple: false,
        title: "Upload Featured",
        library: {
            type: 'image'
        },
        button: {
            text: "Choose Image"
        }
    });
    media_frame.on('select', function () {
        var media_attachment = media_frame.state().get('selection').first().toJSON();
        $('.featured_preview').attr('src', media_attachment.url);
        $('.featured_url').val(media_attachment.url);
    });
    media_frame.open();
}
function change_img(btn) {
    var media_frame;
    if (media_frame) {
        media_frame.open();
        return;
    }
    media_frame = wp.media.frames.media_frame = wp.media({
        frame: 'select',
        multiple: false,
        title: "Upload Featured",
        library: {
            type: 'image'
        },
        button: {
            text: "Choose Image"
        }
    });
    media_frame.on('select', function () {
        var media_attachment = media_frame.state().get('selection').first().toJSON();
        $(btn).siblings('.img_preview').attr('src', media_attachment.url);
        $(btn).siblings('.img_url').val(media_attachment.url);
    });
    media_frame.open();
}
$(document).on('click', '#images_button', function (e) {
    e.preventDefault();
    upload_img();
});
$(document).on('click', '#feature_button', function (e) {
    e.preventDefault();
    upload_featured();
});
$(document).on('click', '.change_img', function (e) {
    e.preventDefault();
    change_img(this);
});
$(document).on('click', '.delete_img', function (e) {
    e.preventDefault();
    $(this).parent().remove();
});
$(document).on('click', '.delete_featured', function (e) {
    e.preventDefault();
    $(this).siblings('.featured_url').val('');
    $(this).siblings('.featured_preview').attr('src', '');
});