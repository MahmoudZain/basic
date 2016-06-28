<?php

/**
 * Created by PhpStorm.
 * User: ZAIN
 * Date: 5/4/2016
 * Time: 3:06 AM
 */
class user
{
    public $id;
    public $name;
    public $email;
    public $password;
    public $guid;

    function __construct($id, $name, $email, $password, $guid)
    {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
        $this->guid = $guid;
    }
}