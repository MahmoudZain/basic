<?php
define("THEME_DIR", get_template_directory_uri());
define("THEME_DOMAIN", 'default');
define("HOME_URL", get_home_url());
define("THEME_PHYSICAL_DIR", get_template_directory());

add_action('init', 'initialize_backend');
add_action('after_setup_theme', 'add_images_sizes');

function initialize_backend()
{
    include_once(THEME_PHYSICAL_DIR . '/back-end/init.php');
    include_once(THEME_PHYSICAL_DIR . '/back-end/rewrite-rules.php');
}

function get_site_lang()
{
    if (isset($_COOKIE['lang'])) {
        if ($_COOKIE['lang'] == 'en') {
            return 'en';
        } elseif ($_COOKIE['lang'] == 'ar') {
            return 'ar';
        } else {
            setcookie('lang', 'en', time() + 1209600, '/', COOKIE_DOMAIN, false, true);
            return 'en';
        }
    } else {
        setcookie('lang', 'en', time() + 1209600, '/', COOKIE_DOMAIN, false, true);
        return 'en';
    }
}

function add_images_sizes()
{
    if (function_exists('add_image_size')) {
        add_image_size('260x200', 260, 200, true);
    }
}