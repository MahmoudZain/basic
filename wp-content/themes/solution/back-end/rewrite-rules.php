<?php
global $wp, $wp_rewrite;
$wp->add_query_var('lang');
$wp->add_query_var('params');

add_rewrite_rule(
    '(ar)/?$', 'index.php?lang=$matches[1]', 'top'
);
add_rewrite_rule(
    '(en)/?$', 'index.php?lang=$matches[1]', 'top'
);

add_rewrite_rule('(en)/(register)/?$', 'index.php?lang=$matches[1]&pagename=$matches[2]', 'top');
add_rewrite_rule('(ar)/(register)/?$', 'index.php?lang=$matches[1]&pagename=$matches[2]', 'top');

add_rewrite_rule('(en)/(login)/?$', 'index.php?lang=$matches[1]&pagename=$matches[2]', 'top');
add_rewrite_rule('(ar)/(login)/?$', 'index.php?lang=$matches[1]&pagename=$matches[2]', 'top');

add_rewrite_rule('(en)/(search)?/?$', 'index.php?pagename=$matches[2]&params=$matches[3]&lang=$matches[1]', 'top');
add_rewrite_rule('(en)/(search)/([^/]+)?/?$', 'index.php?pagename=$matches[2]&params=$matches[3]&lang=$matches[1]', 'top');


add_rewrite_rule('(ar)/(search)?/?$', 'index.php?pagename=$matches[2]&params=$matches[3]&lang=$matches[1]', 'top');
add_rewrite_rule('(ar)/(search)/([^/]+)?/?$', 'index.php?pagename=$matches[2]&params=$matches[3]&lang=$matches[1]', 'top');


add_rewrite_rule('(ajax-handler)/?$', 'index.php?pagename=$matches[1]', 'top');


$wp_rewrite->flush_rules();