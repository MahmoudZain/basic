<?php

/**
 * Created by PhpStorm.
 * User: ZAIN
 * Date: 4/3/2016
 * Time: 10:42 PM
 */
class media
{
    public $id;
    public $url;

    function __construct($id, $url = '')
    {
        $this->id = $id;
        $this->url = $url;
    }
}