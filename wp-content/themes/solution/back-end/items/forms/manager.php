<?php
/**
 * Created by PhpStorm.
 * User: ZAIN
 * Date: 3/24/2016
 * Time: 6:07 PM
 */
if ($_SERVER['REQUEST_METHOD'] == 'GET' && $_GET['action'] == 'edit' && isset($_GET['item_id'])) {
    include_once(THEME_PHYSICAL_DIR . '/back-end/items/forms/edit.php');
} elseif ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['edit_item'])) {
    include_once(THEME_PHYSICAL_DIR . '/back-end/items/forms/edit.php');
} else {
    include_once(THEME_PHYSICAL_DIR . '/back-end/items/forms/listing.php');
}