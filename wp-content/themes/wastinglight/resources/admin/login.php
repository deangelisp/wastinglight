<?php

//
function my_login_logo_url() {
    return home_url();
}
add_filter( 'login_headerurl', 'my_login_logo_url' );

function my_login_logo_url_title() {
    return 'DogCare Website';
}
add_filter( 'login_headertitle', 'my_login_logo_url_title' );

function modify_logo() {
    $logo_style = '<style type="text/css">';
    $logo_style .= 'h1 a {background-image: url(' . get_site_icon_url() . ') !important;     margin-bottom: 10px;}';
    $logo_style .= 'body.login label{color: #FFF;}';
    $logo_style .= 'body.login form{background: #000cff; border-radius: 10px;}';
//    $logo_style .= 'body {background: #ff5f60;}';
    $logo_style .= '</style>';
    echo $logo_style;
}
add_action('login_head', 'modify_logo');