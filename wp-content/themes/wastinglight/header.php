<!DOCTYPE html>
<html <?php language_attributes(); ?>>
    <head>
        <meta charset="<?php bloginfo( 'charset' ); ?>" />
        <meta name="viewport" content="width=device-width" />
        <?php wp_head(); ?>
    </head>
    <body <?php body_class(); ?>>
        <div id="wrapper" class="hfeed">
            <input type="checkbox" id="menuToggle-check" class="none" />

            <header id="main-header" class="main-header">
                <div class="container flex between f-center">
                    <a href="<?php echo get_home_url(); ?>" class="main-branding">
                        <img src="<?php echo get_option('wi_logo_header'); ?>" id="main-branding" />
                    </a>
                    <?php
                    wp_nav_menu( array( 
                        'theme_location' => 'main-menu',
                        'container' => 'nav',
                        'container_class' => 'navigation-menu header flex f-center',
                        'menu_class' => 'menu container',
                        'fallback_cb' => false,
                    ) ); 
                    ?>
                    <label id="nav-icon" for="menuToggle-check" class="menu-toggle-header">
                        <div class="bar1"></div>
                        <div class="bar2"></div>
                        <div class="bar3"></div>
                    </label>
                </div>
            </header>