<?php

class Common_functions
{
    public static function validate_password($password, $re_password)
    {
        $password = sanitize_user($password);
        $re_password = sanitize_user($re_password);
        if ($password == $re_password)
            return true;
        else
            return false;
    }

}