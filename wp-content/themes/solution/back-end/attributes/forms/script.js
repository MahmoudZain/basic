/**
 * Created by ZAIN on 4/29/2016.
 */
function show_values() {
    lang_id = document.getElementsByName('lang_id[]');
    lang_name = document.getElementsByName('lang_name[]');
    div = '<label>Attribute values:</label><div class="attr_value"><label>order: </label><input type="text" name="order[]" style="width: 4%;" data-validation="required">';
    for (var i = 0; i < lang_id.length; i++) {
        div += '<label> ' + lang_name[i].defaultValue + ' value: </label><input type="text" name="attribute_value_' + lang_id[i].defaultValue + '[]" data-validation="required">';
    }
    div += '<input type="button" value="Delete" class="delete-button" onclick="$(this).parent(\'.attr_value\').remove()"><br></div><input id="add_value" type="button" value="Add" class="button" onclick="add_val()">';
    $('.attribute_values').html(div);
}
function hide_values() {
    $('.attribute_values').html('');
}
function add_val() {
    lang_id = document.getElementsByName('lang_id[]');
    lang_name = document.getElementsByName('lang_name[]');
    div = '<div class="attr_value"><label>order: </label><input type="text" name="order[]" style="width: 4%;" data-validation="required">';
    for (var i = 0; i < lang_id.length; i++) {
        div += '<label> ' + lang_name[i].defaultValue + ' value: </label><input type="text" name="attribute_value_' + lang_id[i].defaultValue + '[]" data-validation="required">';
    }
    div += '<input type="button" value="Delete" class="delete-button" onclick="$(this).parent(\'.attr_value\').remove()"><br></div>';
    $('.attr_value').last().after(div);
}
$(document).on('click', '.delete-value', function (e) {
    confirm('Do you want to delete this value ?')
    {
        ajaxurl = 'admin-ajax.php';
        var data = {
            action: 'delete_value',
            value_id: $(this).attr('id')
        };
        $.ajax({
            type: "POST",
            url: ajaxurl,
            data: data,
            success: function (response) {
                $('.value_' + data.value_id).parent('.attr_value').remove();
            },
            error: function (errorThrown) {
                alert(errorThrown);
            }
        });
    }
});