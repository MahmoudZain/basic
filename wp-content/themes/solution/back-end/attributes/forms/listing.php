<?php
include_once(THEME_PHYSICAL_DIR . '/database/bl/attribute.php');
include_once(THEME_PHYSICAL_DIR . '/common-files/config.php');

global $attributes_types;
$attribute_bl = new attribute_bl();
$attributes = $attribute_bl->get_all_attributes();
?>
<div style="overflow: auto;">
    <h2 class="listing-title">Attributes Listing</h2>
    <a class="anchor-add" href="admin.php?page=add_attribute">Add New Attribute</a>
</div>
<?php if ($attributes) { ?>
    <table id="items" class="wp-list-table widefat fixed striped pages">
        <thead>
        <tr class="tableHeader">
            <th>Attribute Name</th>
            <th>Attribute Type</th>
            <th>Edit / Delete</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($attributes as $attribute) { ?>
            <tr id="<?php echo $attribute->id; ?>" class="tableRow">
                <td><?php echo $attribute->attribute_name ?></td>
                <td><?php echo $attributes_types[intval($attribute->attribute_type)] ?></td>
                <td><a class="button"
                       href="admin.php?page=attributes_manager&action=edit&attribute_id=<?php echo $attribute->id; ?>">edit</a>
                    <a class="delete-button"
                       onclick="delete_attribute(<?php echo $attribute->id; ?>,<?php echo $attribute->attribute_type ?>)">Delete</a>
                </td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
<?php } else { ?>
    <h1>No Attributes to show</h1>
<?php } ?>
<script type="text/javascript">
    function delete_attribute(attribute_id, attribute_type) {
        if (confirm('Do You Want to Delete this Attribute ?')) {
            ajaxurl = 'admin-ajax.php';
            var data = {
                action: 'delete_attribute',
                attribute_id: attribute_id,
                attribute_type: attribute_type
            };
            $.ajax({
                type: "POST",
                url: ajaxurl,
                data: data,
                success: function (response) {
                    $('#' + data.attribute_id).remove();
                },
                error: function (errorThrown) {
                    alert(errorThrown);
                }
            });
        }
    }
</script>