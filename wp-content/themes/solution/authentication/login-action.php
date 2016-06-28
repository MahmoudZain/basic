<?php
include_once(THEME_PHYSICAL_DIR . '/database/bl/users.php');
include_once(THEME_PHYSICAL_DIR . '/database/models/user.php');
$user_bl = new users_bl();
$valid = true;
($_POST['remember']) ? $remember = true : $remember = false;
if ($_POST['email'] && $_POST['password']) {
    if (is_email($_POST['email'])) {
        $email = apply_filters('user_registration_email', $_POST['email']);
    } else {
        $valid = false;
        wp_redirect(home_url());
    }
    $password = hash('md5', $_POST['password']);
    if ($valid) {
        $user = $user_bl->user_login($email, $password);
        if (count($user) > 0) {
            include_once(THEME_PHYSICAL_DIR . '/authentication/auth.php');
            Auth::set_auth_cookie($user->id, $user->guid, $remember);
//            header('Location:' . home_url());
        } else {
            header('Location:' . home_url() . '/login?err=1');
        }
    }
}