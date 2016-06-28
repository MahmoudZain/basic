<?php
include_once(THEME_PHYSICAL_DIR . '/common-files/config.php');

add_action('wp_ajax_delete_value', 'delete_value');
add_action('wp_ajax_delete_attribute', 'delete_attribute');

function delete_value()
{
    include_once(THEME_PHYSICAL_DIR . '/database/bl/attribute.php');
    $value_id = $_POST['value_id'];
    $attribute_bl = new attribute_bl();
    $attribute_bl->delete_attribute_value($value_id);
    die('5');
}

function delete_attribute()
{
    include_once(THEME_PHYSICAL_DIR . '/database/bl/attribute.php');
    global $attributes_types;
    include_once(THEME_PHYSICAL_DIR . '/common-files/config.php');
    $attribute_bl = new attribute_bl();
    $attribute_id = $_POST['attribute_id'];
    $attribute_type = $_POST['attribute_type'];
    if ($attribute_type == $attributes_types['drop-down'])
        $attribute_bl->delete_attribute_with_values($attribute_id);
    else
        $attribute_bl->delete_attribute($attribute_id);
    die();
}