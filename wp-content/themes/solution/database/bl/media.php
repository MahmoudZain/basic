<?php
/**
 * Created by PhpStorm.
 * User: ZAIN
 * Date: 4/3/2016
 * Time: 10:42 PM
 */

include_once(get_template_directory() . '/database/dal/media.php');
include_once(get_template_directory() . '/database/db-integration/wp_api.php');

class media_bl
{
    private $dal;

    function __construct()
    {
        $db = new wp_api();
        $this->dal = new media_dal($db);
    }

    function add_media($media)
    {
        return $this->dal->add_media($media);
    }

    function get_image_by_media_id($media_id)
    {
        return $this->dal->get_image_by_media_id($media_id)[0]->media_url;
    }

    function update_media($media)
    {
        return $this->dal->update_media($media);
    }

    function delete_media($media_id)
    {
        return $this->dal->delete_media($media_id);
    }
}