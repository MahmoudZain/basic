<?php
include_once(THEME_PHYSICAL_DIR . '/authentication/auth.php');
if (Auth::check_auth_cookie()) {
    wp_redirect(home_url());
} else {
    get_header();
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        require_once THEME_PHYSICAL_DIR . '/authentication/login-action.php';
    } else
        get_template_part('front-end/user/login', 'form');
    get_footer();
}