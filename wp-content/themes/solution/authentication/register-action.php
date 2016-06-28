<?php
include_once(THEME_PHYSICAL_DIR . '/database/bl/users.php');
include_once(THEME_PHYSICAL_DIR . '/database/models/user.php');
include_once(THEME_PHYSICAL_DIR . '/common-files/common-functions.php');
$user_bl = new users_bl();
$valid = true;
($_POST['remember']) ? $remember = true : $remember = false;
if ($_POST['user_name'] && $_POST['email'] && $_POST['password_confirmation'] && $_POST['password']) {
    $user_name = sanitize_user($_POST['user_name']);
    $email = apply_filters('user_registration_email', $_POST['email']);
    $email_exist = $user_bl->is_email_exist($email);
    if (count($email_exist) > 0) {
        $valid = false;
        wp_redirect(home_url());
    }
    if (Common_functions::validate_password($_POST['password_confirmation'], $_POST['password'])) {
        $password = hash('md5', $_POST['password']);
    } else {
        $valid = false;
        wp_redirect(home_url());
    }
    $guid = uniqid();
    if ($valid) {
        $user = new user(0, $user_name, $email, $password, $guid);
        $user_id = $user_bl->user_register($user);
        if ($user_id > 0) {
            include_once(THEME_PHYSICAL_DIR . '/authentication/auth.php');
            Auth::set_auth_cookie($user_id, $guid, $remember);
        }
    }
}