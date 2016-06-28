<?php

$result = '';
if (isset($_POST['email'])) {
    $email = $_POST['email'];
    $result = is_email_exist($email);
}
if ($_POST['action']) {
    $action = $_POST['action'];
    if ($action == 'change_language') {
        $lang = $_POST['lang'];
        $result = ajax_change_language($lang);
    } elseif ($action == 'search') {
        $keyword = $_POST['keyword'];
        $attributes = $_POST['attributes'];
        $attributes_range = $_POST['attributes_range'];
        $page_from = $_POST['page_from'];
        $page_count = $_POST['page_count'];
        $result = ajax_get_search_results($keyword, $page_from, $page_count, $attributes, $attributes_range);
    }
}
echo json_encode($result);
die();

function is_email_exist($email)
{
    include_once(THEME_PHYSICAL_DIR . '/database/bl/users.php');
    $user_bl = new users_bl();
    $result = $user_bl->is_email_exist($email);
    if (count($result)) {
        // User email is registered on another account
        $response = array('valid' => false, 'message' => 'This E-mail name is already registered.');
    } else {
        // User email is available
        $response = array('valid' => true);
    }
    return $response;
}

function ajax_change_language($lang)
{
    if ($lang == 'en')
        return setcookie('lang', 'en', time() + 1209600, '/', COOKIE_DOMAIN, false, true);
    elseif ($lang == 'ar')
        return setcookie('lang', 'ar', time() + 1209600, '/', COOKIE_DOMAIN, false, true);
}

function str_lreplace($search, $replace, $subject)
{
    $pos = strrpos($subject, $search);

    if ($pos !== false) {
        $subject = substr_replace($subject, $replace, $pos, strlen($search));
    }

    return $subject;
}

function ajax_get_search_results($keyword = '', $page_from, $page_count, $attributes, $attributes_range)
{
    include_once(THEME_PHYSICAL_DIR . '/database/bl/items.php');
    include_once(THEME_PHYSICAL_DIR . '/common-files/config.php');
    global $languages;
    $lang = get_site_lang();
    $lang_id = $languages[$lang];
    $filters = array();
    if ($keyword != '')
        $filters['keyword'] = $keyword;
    if (isset($page_from) && isset($page_count)) {
        $filters['pagination'] = true;
        $filters['page_from'] = intval($page_from);
        $filters['page_count'] = intval($page_count);
    }
    $item_bl = new items_bl();
    $items = $item_bl->get_search_items($lang_id, $filters, $attributes, $attributes_range);
    $html = "";
    foreach ($items as $item) {
        $html .= '<div class="block col-lg-4 col-sm-4">
                        <div class="block-action">
                            <div class="block-img">
                                <img src="' . $item->url . '"
                                     class="img-responsive" alt=""/>

                                <div class="block-icons">
                                    <a href="#"><img src="' . THEME_DIR . '/front-end/assets/img/pro-icon3.png"
                                                     alt=""/></a>
                                    <a href="#"><img src="' . THEME_DIR . '/front-end/assets/img/pro-icon2.png"
                                                     alt=""/></a>
                                    <a href="#"><img src="' . THEME_DIR . '/front-end/assets/img/pro-icon.png"
                                                     alt=""/></a>
                                </div>
                            </div>
                            <div class="block-head">
                                <header>' . $item->name . '</header>
                            </div>
                        </div>
                    </div>';
    }
    return $html;
}