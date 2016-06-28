<?php
/**
 * Created by PhpStorm.
 * User: ZAIN
 * Date: 4/29/2016
 * Time: 2:34 AM
 */
add_action('wp_ajax_delete_media', 'delete_media');
add_action('wp_ajax_delete_item', 'delete_item');

function delete_media()
{
    include_once(THEME_PHYSICAL_DIR . '/database/bl/media.php');
    include_once(THEME_PHYSICAL_DIR . '/database/bl/gallery.php');
    $media_id = $_POST['media_id'];
    $media_bl = new media_bl();
    $gallery_bl = new gallery_bl();
    $media_bl->delete_media($media_id);
    $gallery_bl->delete_media_from_gallery($media_id);
    die();
}

function delete_item()
{
    include_once(THEME_PHYSICAL_DIR . '/database/bl/items.php');
    $item_bl = new items_bl();
    $item_id = $_POST['item_id'];
    $item_bl->delete_item_by_id($item_id);
    die();
}