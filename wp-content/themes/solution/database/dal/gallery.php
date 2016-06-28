<?php
/**
 * Created by PhpStorm.
 * User: ZAIN
 * Date: 4/4/2016
 * Time: 3:13 AM
 */
include_once(get_template_directory() . '/database/db-integration/wp_api.php');
include_once(get_template_directory() . '/database/db-integration/db_helper.php');

class gallery_dal
{
    private $dbObj;

    function __construct(db_helper $db)
    {
        $this->dbObj = $db;
    }

    function add_gallery($gallery)
    {
        $query = "INSERT INTO `galleries`(`date_time`) VALUES ('" . $gallery->date_time . "')";
        return $this->dbObj->execute_rc($query);
    }

    function assign_media_to_gallery($media_id, $gallery_id)
    {
        $query = "INSERT INTO `gallery_media`(`gallery_id`, `media_id`) VALUES (" . $gallery_id . "," . $media_id . ")";
        return $this->dbObj->execute($query);
    }

    function assign_gallery_to_item($item_id, $gallery_id)
    {
        $query = "INSERT INTO `item_gallery`(`item_id`, `gallery_id`) VALUES (" . $item_id . "," . $gallery_id . ")";
        return $this->dbObj->execute($query);
    }

    function delete_media_from_gallery($media_id)
    {
        $query = "DELETE FROM `gallery_media` WHERE `media_id`=" . $media_id;
        return $this->dbObj->execute($query);
    }

    function delete_gallery($gallery_id)
    {
        $query = "DELETE FROM `galleries` WHERE `id`=" . $gallery_id;
        return $this->dbObj->execute($query);
    }

    function delete_gallery_media($media_id)
    {
        $query = "DELETE FROM `gallery_media` WHERE `media_id`=" . $media_id;
        return $this->dbObj->execute($query);
    }

}