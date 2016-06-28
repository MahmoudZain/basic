<?php

$lang = get_site_lang();
if ($lang !== get_query_var('lang')) {
    $url = $_SERVER['REQUEST_URI'];
    $new_url = site_url() . '/' . substr_replace($url, $lang, strpos($url, '/'), strpos($url, '/', 1));
    header('HTTP/1.1 301 Moved Permanently');
    header('Location:' . $new_url);
}
if ($lang == 'en') {
    change_localization('en');
} elseif ($lang == 'ar') {
    change_localization('ar_EG');
}
function change_localization($lang)
{
    global $locale;
    $locale = $lang;
    $language = $lang;
    unload_textdomain('default');
    load_textdomain('default', THEME_PHYSICAL_DIR . "/languages/$language.mo");
}

?>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>New Homeland</title>
    <link href="<?php echo THEME_DIR; ?>/front-end/assets/css/bootstrap.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo THEME_DIR; ?>/front-end/assets/css/bootstrap.min.css">
    <link href="<?php echo THEME_DIR; ?>/front-end/assets/css/font-roboto.css" rel="stylesheet">
    <link href="<?php echo THEME_DIR; ?>/front-end/assets/css/font-awesome.css" rel="stylesheet">
    <link href="<?php echo THEME_DIR; ?>/front-end/assets/css/main.css" rel="stylesheet">

    <script src="<?php echo THEME_DIR; ?>/front-end/assets/js/jquery.js"></script>
    <script src="<?php echo THEME_DIR; ?>/front-end/assets/js/bootstrap.js"></script>
    <!--    <script src="--><?php //echo THEME_DIR; ?><!--/front-end/assets/js/jquery-1.11.1.min.js"></script>-->
    <!--    <script src="--><?php //echo THEME_DIR; ?><!--/front-end/assets/js/bootstrap.min.js"></script>-->
    <?php if (is_page('register') || is_page('login')) {
        echo '<script src="' . THEME_DIR . '/front-end/assets/js/jquery.form-validator.min.js"></script>';
    } ?>
</head>

<body>
<header>
    <div class="mini-bar navbar-inverse" role="navigation">
        <div class="container">
            <div class="row">
                <div class="margin-right collapse navbar-collapse pull-right">
                    <ul class="nav navbar-nav navbar-sub">
                        <li><a href="/<?php echo $_COOKIE['lang']; ?>/login">Login/Register</a></li>
                        <li class="dropdown">
                            <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown" role="button"
                               aria-expanded="false"><?php
                                switch ($_COOKIE['lang']) {
                                    case 'en' :
                                        echo 'English';
                                        break;
                                    case 'ar':
                                        echo 'العربية';
                                        break;
                                }
                                ?>
                                <span class="caret"></span></a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="javascript:void(0)" onclick="change_language('en')">English</a></li>
                                <li><a href="javascript:void(0)" onclick="change_language('ar')">العربية</a></li>
                            </ul>
                        </li>
                    </ul>
                    <!-- nav end -->
                </div>
                <!-- nav-collapse end -->
            </div>
            <!-- row end -->
        </div>
        <!-- container end -->
    </div>
    <!-- mini-bar end -->
    <div class="main-menu-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-4 col-sm-4">
                            <div class="slogan">
                                <p><span>New Homeland</span></p>
                            </div>
                        </div>

                        <div class="col-lg-6 col-sm-6 main-nav">
                            <div class="margin-right">
                                <ul class="main-nav-ul nav navbar-nav navbar-sub">
                                    <li><a href="/<?php echo $_COOKIE['lang']; ?>/search">Search</a></li>
                                </ul>
                            </div>
                            <!--/.nav-collapse -->
                        </div>
                        <!-- main-nav end -->
                    </div>
                    <!-- row end -->

                </div>
                <!-- col-lg-12 end -->
            </div>
            <!-- row end -->
        </div>
        <!-- container end -->
    </div>
</header>
<!-- header end -->
<script type="text/javascript">
    function change_language(lang) {

        ajax_url = "/ajax-handler/";
        var data = {
            action: 'change_language',
            lang: lang
        };
        $.ajax({
            type: "POST",
            url: ajax_url,
            data: data,
            success: function (response) {
                var result = $.parseJSON(response);
                if (result == true)
                    location.reload();
            }
        });
    }
</script>