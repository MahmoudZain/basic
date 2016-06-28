<?php
include_once(THEME_PHYSICAL_DIR . '/database/bl/items.php');

$items_bl = new items_bl();
$keyword = new stdClass();
if (isset($_GET['keyword']) && $_GET['keyword']) {
    $keyword->value = $_GET['keyword'];
}
$filters = array('keyword' => $keyword);
$items = $items_bl->get_items($filters);
?>
<script src="<?php echo THEME_DIR; ?>/back-end/assets/js/jquery.simplePagination.js"></script>
<div style="overflow: auto;">
    <h2 class="listing-title">Items Listing</h2>
    <a class="anchor-add" href="admin.php?page=add">Add New Item</a>
</div>
<table class="wp-list-table page fixed">
    <tbody>
    <tr>
        <td><label>Search by Name:</label></td>
        <td><input id="search_txt" type="text" value="<?php echo $_GET['keyword'] ?>"></td>
        <td>
            <button id="search-btn">Search</button>
        </td>
    </tr>
    </tbody>
</table>
<hr>
<?php if ($items) { ?>
    <table id="items" class="wp-list-table widefat fixed striped pages">
        <thead>
        <tr class="tableHeader">
            <th>Item Name</th>
            <th>Edit / Delete</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($items as $item) { ?>
            <tr id="<?php echo $item->id; ?>" class="tableRow">
                <td><?php echo $item->name ?></td>
                <td><a class="button"
                       href="admin.php?page=item_manager&action=edit&item_id=<?php echo $item->id; ?>">edit</a>
                    <a class="delete-button" onclick="delete_item(<?php echo $item->id; ?>)">Delete</a>
                </td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
<?php } else { ?>
    <h1>No Items to show</h1>
<?php } ?>

<script type="text/javascript">
    $(document).on('click', '#search-btn', function (e) {
        window.location.href = "?page=item_manager&keyword=" + $('#search_txt').val();
    });
    $(function () {
        $("#items").simplePagination({
            previousButtonClass: "btn btn-danger",
            nextButtonClass: "btn btn-danger"
        });
    });
    function delete_item(item_id) {
        if (confirm('Are You Sure ?')) {
            ajaxurl = 'admin-ajax.php';
            var data = {
                action: 'delete_item',
                item_id: item_id
            };
            $.ajax({
                type: "POST",
                url: ajaxurl,
                data: data,
                success: function (response) {
                    $('#' + data.item_id).remove();
                },
                error: function (errorThrown) {
                    alert(errorThrown);
                }
            });
        }
    }

</script>