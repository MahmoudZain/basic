<?php
/**
 * Created by PhpStorm.
 * User: ZAIN
 * Date: 3/24/2016
 * Time: 1:16 AM
 */
if (is_admin()) {
    add_action('admin_menu', 'initialize_attributes_menu');
    add_action('admin_enqueue_scripts', 'load_attribute_scripts');
    wp_enqueue_media();
    include_once 'ajax.php';
}
function initialize_attributes_menu()
{
    add_menu_page('Attributes', 'Attributes', 'manage_options', 'attributes_manager', 'initialize_attributes_manager', '', 100);
    add_submenu_page('attributes_manager', 'Add new Attribute', 'Add new Attributes', 'manage_options', 'add_attribute', 'initialize_add_attribute');
}

function initialize_attributes_manager()
{
    require_once THEME_PHYSICAL_DIR . '/back-end/attributes/forms/manager.php';
}

function initialize_add_attribute()
{
    require_once THEME_PHYSICAL_DIR . '/back-end/attributes/forms/add_attribute.php';
}

function load_attribute_scripts()
{
    wp_enqueue_script('media-uploader', THEME_DIR . '/back-end/assets/js/jquery-1.11.1.min.js');
    wp_enqueue_script('media-uploader', THEME_DIR . '/back-end/assets/js/media-uploader.js');
    wp_enqueue_style('style', THEME_DIR . '/back-end/assets/css/backend-style.css');
    wp_enqueue_style('style-jquery', THEME_DIR . '/back-end/assets/css/ui-jquery.css');


}