<?php
/**
 * Created by PhpStorm.
 * User: ZAIN
 * Date: 4/3/2016
 * Time: 10:42 PM
 */

include_once(get_template_directory() . '/database/db-integration/wp_api.php');
include_once(get_template_directory() . '/database/db-integration/db_helper.php');

class media_dal
{
    private $dbObj;

    function __construct(db_helper $db)
    {
        $this->dbObj = $db;
    }

    function add_media($media)
    {
        $query = "INSERT INTO `media`(`media_url`) VALUES ('" . $media->url . "')";
        return $this->dbObj->execute_rc($query);
    }

    function get_image_by_media_id($media_id)
    {
        $query = "SELECT `media_url` FROM `media` WHERE `id`=" . $media_id;
        return $this->dbObj->execute($query);
    }

    function update_media($media)
    {
        $query = "UPDATE `media` SET `media_url`='" . $media->url . "' WHERE `id`=" . $media->id;
        return $this->dbObj->execute($query);
    }

    function delete_media($media_id)
    {
        $query = "DELETE FROM `media` WHERE `id`=" . $media_id;
        return $this->dbObj->execute($query);
    }
}