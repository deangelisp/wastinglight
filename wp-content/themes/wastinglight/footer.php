<footer id="footer" class="main-footer">
    <div class="container flex">
        <div class="col-6 col-sm-12">
            <img src="<?php echo get_option('wi_logo_footer'); ?>" class="footer-logo"/>
        </div>
        <div class="col-6 col-sm-12">
            <div class="flex">
                <?php
                
                $instagram = get_option('wi_instagram');
                $facebook = get_option('wi_facebook');
                $youtube = get_option('wi_youtube');
                
                wp_nav_menu( array( 
                    'theme_location' => 'menu-footer-left',
                    'container' => 'nav',
                    'container_class' => 'footer-menu left col-6 col-sm-12',
                    'menu_class' => '',
                    'fallback_cb' => false,
                ) );
                
                echo '<div class="col-6 col-sm-12">';
                
                wp_nav_menu( array( 
                    'theme_location' => 'menu-footer-right',
                    'container' => 'nav',
                    'container_class' => 'footer-menu right',
                    'menu_class' => '',
                    'fallback_cb' => false,
                ) ); 
                
                echo '<ul class="flex  f-center footer-social-media">';
                echo $instagram ? '<li><a href=""><img src="'.get_template_directory_uri().'/assets/icons/instagram.png" /></a></li>': '';
                echo $facebook ? '<li><a href=""><img src="'.get_template_directory_uri().'/assets/icons/facebook.png" /></a></li>': '';
                echo $youtube ? '<li><a href=""><img src="'.get_template_directory_uri().'/assets/icons/youtube.png" /></a></li>': '';
                echo '</ul>';
                
                echo '</div>';
                ?>
            </div>
            <div id="copyright" class="copyright">
                &copy; <?php echo esc_html( date_i18n( __( 'Y', 'blankslate' ) ) ); ?> <?php echo esc_html( get_bloginfo( 'name' ) ); ?>
            </div>
        </div>
    </div>
</footer>
</div>
<?php wp_footer(); ?>
</body>
</html>