<?php
/**
 * Created by PhpStorm.
 * User: ZAIN
 * Date: 3/24/2016
 * Time: 1:16 AM
 */
if (is_admin()) {
    add_action('admin_menu', 'initialize_item_menu');
    add_action('admin_enqueue_scripts', 'load_item_scripts');
    wp_enqueue_media();
    include_once 'ajax.php';
}
function initialize_item_menu()
{
    add_menu_page('Items', 'Items', 'manage_options', 'item_manager', 'initialize_item_manager', '', 100);
    add_submenu_page('item_manager', 'Add new Item', 'Add new Item', 'manage_options', 'add', 'initialize_add_item');
}

function initialize_item_manager()
{
    require_once THEME_PHYSICAL_DIR . '/back-end/items/forms/manager.php';
}

function initialize_add_item()
{
    require_once THEME_PHYSICAL_DIR . '/back-end/items/forms/add.php';
}

function load_item_scripts()
{
    wp_enqueue_script('media-uploader', THEME_DIR . '/back-end/assets/js/jquery-1.11.1.min.js');
    wp_enqueue_script('media-uploader', THEME_DIR . '/back-end/assets/js/media-uploader.js');
    wp_enqueue_style('style', THEME_DIR . '/back-end/assets/css/backend-style.css');
    wp_enqueue_style('style-jquery', THEME_DIR . '/back-end/assets/css/ui-jquery.css');


}