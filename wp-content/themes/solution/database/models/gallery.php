<?php

/**
 * Created by PhpStorm.
 * User: ZAIN
 * Date: 4/3/2016
 * Time: 11:01 PM
 */
class gallery
{
    public $id;
    public $date_time;

    function __construct($id, $date_time = '')
    {
        $this->id = $id;
        $this->date_time = $date_time;
    }
}