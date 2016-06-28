<?php

/**
 * Created by PhpStorm.
 * User: ZAIN
 * Date: 3/25/2016
 * Time: 5:58 PM
 */
class item
{
    public $id;
    public $name;
    public $media_id;
    public $user_id;

    public function __construct($id, $name = '', $media_id = '', $user_id = '')
    {
        $this->id = $id;
        $this->name = $name;
        $this->media_id = $media_id;
        $this->user_id = $user_id;
    }
}