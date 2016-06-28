<?php
include_once(get_template_directory() . '/database/dal/users.php');
include_once(get_template_directory() . '/database/db-integration/wp_api.php');

class users_bl
{
    private $dal;

    function __construct()
    {
        $db = new wp_api();
        $this->dal = new users_dal($db);
    }

    function get_all_users()
    {
        return $this->dal->get_all_users();
    }

    function user_register($user)
    {
        return $this->dal->user_register($user);
    }

    function user_login($mail, $password)
    {
        return $this->dal->user_login($mail, $password);
    }

    function is_email_exist($email)
    {
        $result = $this->dal->is_email_exist($email);
        return $result;
    }

    function get_user_by_id($id)
    {
        return $this->dal->get_user_by_id($id);
    }
}

?>