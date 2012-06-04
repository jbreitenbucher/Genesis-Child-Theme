<?php
/**
 * Functions
 *
 * @package     jb
 * @author      Jon Breitenbucher <jon@breitenbucher.net>
 * @copyright   Copyright (c) 2012, Jon Breitenbucher
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 *
 */

/**
 * Theme Setup
 *
 * This setup function attaches all of the site-wide functions 
 * to the correct hooks and filters. All the functions themselves
 * are defined below this setup function.
 *
 */

add_action('genesis_setup', 'jb_theme_setup', 15);
function jb_theme_setup() {
    
    /** Start the engine */
    require_once( get_template_directory() . '/lib/init.php' );
    require_once( get_stylesheet_directory() . '/lib/init.php' );
    
    /** Child theme (do not remove) */
    define( 'CHILD_THEME_NAME', 'Sample Child Theme' );
	define( 'CHILD_THEME_URL', 'http://www.studiopress.com/themes/genesis' );
    
    // Add support for theme options
    add_action( 'admin_init', 'jb_reset' );
    add_action( 'admin_init', 'jb_register_settings' );
    add_action( 'admin_menu', 'jb_add_menu', 100);
    add_action( 'admin_notices', 'jb_notices' );
    add_action( 'genesis_settings_sanitizer_init', 'jb_recipe_sanitization_filters' );
    
    // Unregister layout setting
    genesis_unregister_layout( 'sidebar-content' );
    genesis_unregister_layout( 'content-sidebar-sidebar' );
    genesis_unregister_layout( 'sidebar-sidebar-content' );
    genesis_unregister_layout( 'sidebar-content-sidebar' );
    
    // Unregister Genesis Sidebars
    add_action( 'widgets_init', 'jb_remove_sidebars' );
    
    // Customize Header
    //remove_action( 'genesis_header', 'genesis_do_header' );
    //add_action( 'genesis_header', 'jb_header' );
    
    // Add new featured image sizes
    add_image_size('slider', 588, 264, TRUE);
    add_image_size('post_image', 330, 232, TRUE);
    add_image_size('post_thumb', 390, 426, TRUE);
    add_image_size('profile-picture-single',150,146, TRUE);

	/** Add support for custom background */
	add_custom_background();
	
	/** Add support for BBPress */
	add_theme_support( 'bbpress' );

	/** Add support for custom header */
	add_theme_support( 'genesis-custom-header', array( 'width' => 960, 'height' => 100 ) );

    
    // Add support for 3-column footer widgets
    //add_theme_support( 'genesis-footer-widgets', 3 );

    // Add Viewport meta tag for mobile browsers
    add_action( 'genesis_meta', 'add_viewport_meta_tag' );
    
    // Customize breadcrumb display
    add_filter( 'genesis_breadcrumb_args', 'jb_breadcrumb_args' );
    
    // Register Sidebars
    genesis_register_sidebar( array(
        'id'            => 'home-left',
        'name'          => __( 'Bottom Left Homepage' ),
        'description'   => __( 'This is a featured section on the homepage.' ),
    ) );
    genesis_register_sidebar( array(
        'id'            => 'home-middle',
        'name'          => __( 'Bottom Middle Homepage' ),
        'description'   => __( 'This is a featured section on the homepage.' ),
    ) );
    genesis_register_sidebar( array(
        'id'            => 'home-right',
        'name'          => __( 'Bottom Right Homepage' ),
        'description'   => __( 'This is a featured section on the homepage.' ),
    ) );
}