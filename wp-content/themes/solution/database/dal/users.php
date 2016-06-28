<?php
include_once(get_template_directory() . '/database/db-integration/db_helper.php');

class users_dal
{
    private $dbObj;

    function __construct(db_helper $db)
    {
        $this->dbObj = $db;
    }

    function get_all_users()
    {
        $query = "SELECT `id`, `name`, `mail`, `guid` FROM `users`";
        return $this->dbObj->execute($query);
    }

    function user_register($user)
    {
        $query = "INSERT INTO `users`(`name`, `mail`, `password`, `guid`)"
            . " VALUES ('" . $user->name . "','" . $user->email . "','" . $user->password . "','" . $user->guid . "')";
        return $this->dbObj->execute_rc($query);
    }

    function user_login($mail, $password)
    {
        $query = "SELECT `id`, `name`, `mail`, `guid` FROM `users` WHERE mail='" . $mail . "' and password='" . $password . "'";
        return $this->dbObj->execute($query)[0];
    }

    function is_email_exist($email)
    {
        $query = "SELECT * FROM `users` WHERE `mail`='" . $email . "'";
        return $this->dbObj->execute($query);
    }

    function get_user_by_id($id)
    {
        $query = "SELECT `id`, `name`, `mail`, `guid` FROM `users` WHERE `id`=" . $id;
        return $this->dbObj->execute($query);
    }
}

?>