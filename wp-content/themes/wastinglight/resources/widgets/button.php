<?php
/*
Plugin Name: Extend Visual Composer Plugin Example
Plugin URI: http://wpbakery.com/vc
Description: Extend Visual Composer with your own set of shortcodes.
Version: 0.1.1
Author: WPBakery
Author URI: http://wpbakery.com
License: GPLv2 or later
*/

/*
This example/starter plugin can be used to speed up Visual Composer plugins creation process.
More information can be found here: http://kb.wpbakery.com/index.php?title=Category:Visual_Composer
*/

// don't load directly
if (!defined('ABSPATH')) die('-1');

class VCExtendAddonClass {
    function __construct() {
        // We safely integrate with VC with this hook
        add_action( 'init', array( $this, 'integrateWithVC' ) );

        // Use this when creating a shortcode addon
        add_shortcode( 'custom_button', array( $this, 'renderCustomButton' ) );

        // Register CSS and JS
        add_action( 'wp_enqueue_scripts', array( $this, 'loadCssAndJs' ) );
    }

    public function integrateWithVC() {
        // Check if Visual Composer is installed
        if ( ! defined( 'WPB_VC_VERSION' ) ) {
            // Display notice that Visual Compser is required
            add_action('admin_notices', array( $this, 'showVcVersionNotice' ));
            return;
        }

        /*
        Add your Visual Composer logic here.
        Lets call vc_map function to "register" our custom shortcode within Visual Composer interface.

        More info: http://kb.wpbakery.com/index.php?title=Vc_map
        */
        vc_map( array(
            "name" => 'Custom Button',
            "base" => "custom_button",
            "class" => "",
            "controls" => "full",
            "icon" =>  get_site_icon_url(), // or css class name which you can reffer in your css file later. Example: "vc_extend_my_class"
            "category" => __('Content', 'js_composer'),
            //'admin_enqueue_js' => array(plugins_url('assets/vc_extend.js', __FILE__)), // This will load js file in the VC backend editor
            //'admin_enqueue_css' => array(plugins_url('assets/vc_extend_admin.css', __FILE__)), // This will load css file in the VC backend editor
            "params" => array(
                array(
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => __("Text", 'vc_extend'),
                    "param_name" => "foo",
                    "value" => __("Button Title", 'vc_extend'),
                ),array(
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => __("Link", 'vc_extend'),
                    "param_name" => "Link",
                    "value" => '#',
                ),
                array(
                    "type" => "checkbox",
                    "holder" => "div",
                    "class" => "",
                    "heading" => __( "Separator", "my-text-domain" ),
                    "param_name" => "line",
                    "value" => false,
                    "description" => __( "Horizontal Separator line.", "my-text-domain" )
                ),
                array(
                    "type" => "checkbox",
                    "holder" => "div",
                    "class" => "",
                    "heading" => __( "Alignment (Center)", "my-text-domain" ),
                    "param_name" => "center",
                    "value" => false,
                    "description" => __( "Select to align the button on the center of the section.", "my-text-domain" )
                )
            )
        ) );
    }

    /*
    Shortcode logic how it should be rendered
    */
    public function renderCustomButton( $atts, $content = null ) {
        extract( shortcode_atts( array(
            'foo' => 'something',
            'link' => '#',
            'line' => false,
            'center' => false,
        ), $atts ) );

        $content = wpb_js_remove_wpautop($content, true); // fix unclosed/unwanted paragraph tags in $content
        
        $class = $atts['center'] ? 'center-absolute' : '';

        $output = '';
        $output .= $atts['center'] ? '<div class="button-center">' : '';
        $output .= $atts['line'] ? '<div class="button-line aligncenter">' : '';
        $output .= "<a class='button {$class}' href='{$atts['link']}'>{$atts['foo']}</a>";
        $output .= $atts['line'] ? '</div>' : '';
        $output .= $atts['center'] ? '</div>' : '';
        return $output;
    }

    /*
    Load plugin css and javascript files which you may need on front end of your site
    */
    public function loadCssAndJs() {
        wp_register_style( 'vc_extend_style', plugins_url('assets/vc_extend.css', __FILE__) );
        wp_enqueue_style( 'vc_extend_style' );

        // If you need any javascript files on front end, here is how you can load them.
        //wp_enqueue_script( 'vc_extend_js', plugins_url('assets/vc_extend.js', __FILE__), array('jquery') );
    }

    /*
    Show notice if your plugin is activated but Visual Composer is not
    */
    public function showVcVersionNotice() {
        $plugin_data = get_plugin_data(__FILE__);
        echo '
        <div class="updated">
          <p>'.sprintf(__('<strong>%s</strong> requires <strong><a href="http://bit.ly/vcomposer" target="_blank">Visual Composer</a></strong> plugin to be installed and activated on your site.', 'vc_extend'), $plugin_data['Name']).'</p>
        </div>';
    }
}
// Finally initialize code
new VCExtendAddonClass();