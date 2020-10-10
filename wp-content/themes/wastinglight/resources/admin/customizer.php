<?php
add_action( 'customize_register', 'cd_customizer_settings' );
function cd_customizer_settings( $wp_customize ) {

    //Sanitization
    //    file input sanitization function
    function theme_slug_sanitize_file( $file, $setting ) {

        //allowed file types
        $mimes = array(
            'jpg|jpeg|jpe' => 'image/jpeg',
            'gif'          => 'image/gif',
            'png'          => 'image/png'
        );

        //check file type from file name
        $file_ext = wp_check_filetype( $file, $mimes );

        //if file has a valid mime type return it, otherwise return default
        return ( $file_ext['ext'] ? $file : $setting->default );
    }

    //SECTIONS
    $wp_customize->add_section( 
        'website_info', 
        array(
            'title' => 'Wasting Light - Information',
            'priority' => 150
        )
    );

    //Website Info settings
    $wp_customize->add_setting( 
        'wi_logo_header', 
        array(
            'type' => 'option',
            'sanitize_callback' => 'theme_slug_sanitize_file' //removes all HTML from content
        )
    ); 
    
    $wp_customize->add_setting( 
        'wi_logo_footer', 
        array(
            'type' => 'option',
            'sanitize_callback' => 'theme_slug_sanitize_file' //removes all HTML from content
        )
    ); 


    $wp_customize->add_setting( 'wi_facebook', array('type' => 'option'));
    $wp_customize->add_setting( 'wi_instagram', array('type' => 'option'));
    $wp_customize->add_setting( 'wi_youtube', array('type' => 'option'));

    //control   
    $wp_customize->add_control( 
        new WP_Customize_Upload_Control( 
            $wp_customize, 
            'wi_logo_header', 
            array(
                'label'      => 'Logo (Header)',
                'section'    => 'website_info'                   
            )
        ) 
    );
    
    $wp_customize->add_control( 
        new WP_Customize_Upload_Control( 
            $wp_customize, 
            'wi_logo_footer', 
            array(
                'label'      => 'Logo (Footer)',
                'section'    => 'website_info'                   
            )
        ) 
    );

    $wp_customize->add_control( 'wi_facebook', 
                               array(
                                   'label'      => 'Facebook (link)',
                                   'section'    => 'website_info', 
                                   'type'       => 'text',
                               )); 

    $wp_customize->add_control( 'wi_instagram', 
                               array(
                                   'label'      => 'Instagram (link)',
                                   'section'    => 'website_info', 
                                   'type'       => 'text',
                               )); 

    $wp_customize->add_control( 'wi_youtube', 
                               array(
                                   'label'      => 'Youtube (link)',
                                   'section'    => 'website_info', 
                                   'type'       => 'text',
                               )); 


}

function remove_customizer_settings( $wp_customize ){
    $wp_customize->remove_section( 'static_front_page' );
    $wp_customize->remove_section( 'custom_css' );
//    $wp_customize->remove_panel('nav_menus');
    $wp_customize->remove_panel( 'widgets' );

    //    $wp_customize->get_panel( 'nav_menus' )->active_callback = '__return_false';

}
add_action( 'customize_register', 'remove_customizer_settings', 20 );
