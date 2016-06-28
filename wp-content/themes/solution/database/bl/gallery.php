<?php
/**
 * Created by PhpStorm.
 * User: ZAIN
 * Date: 4/4/2016
 * Time: 3:17 AM
 */
include_once(get_template_directory() . '/database/dal/gallery.php');
include_once(get_template_directory() . '/database/db-integration/wp_api.php');

class gallery_bl
{
    private $dal;

    function __construct()
    {
        $db = new wp_api();
        $this->dal = new gallery_dal($db);
    }

    function add_gallery($gallery)
    {
        return $this->dal->add_gallery($gallery);
    }

    function assign_media_to_gallery($media_id, $gallery_id)
    {
        return $this->dal->assign_media_to_gallery($media_id, $gallery_id);
    }

    function assign_gallery_to_item($item_id, $gallery_id)
    {
        return $this->dal->assign_gallery_to_item($item_id, $gallery_id);
    }

    function delete_media_from_gallery($media_id)
    {
        return $this->dal->delete_media_from_gallery($media_id);
    }

    function delete_gallery($gallery_id)
    {
        return $this->dal->delete_gallery($gallery_id);
    }

    function delete_gallery_media($media_id)
    {
        return $this->dal->delete_gallery_media($media_id);
    }

}