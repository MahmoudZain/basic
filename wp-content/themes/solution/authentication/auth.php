<?php

class Auth
{
    public static function set_auth_cookie($id, $guid, $remember)
    {
        if ($remember) $expiration = time() + 1209600;
        else $expiration = time() + 172800;
        $cookie = $id . '|' . $guid . '|' . $expiration;
        if (setcookie('Auth', $cookie, $expiration, '/', COOKIE_DOMAIN, false, true))
            return true;
        else
            return false;
    }

    public static function check_auth_cookie()
    {
        if ($_COOKIE['Auth']) {
            list($id, $guid, $expiration) = explode('|', $_COOKIE['Auth']);
            if ($expiration < time())
                return false;
            include_once(THEME_PHYSICAL_DIR . '/database/bl/users.php');
            $user_bl = new users_bl();
            $user = $user_bl->get_user_by_id($id)[0];
            if ($guid == $user->guid) {
                return $guid;
            } else return false;
        } else
            return false;
    }
}