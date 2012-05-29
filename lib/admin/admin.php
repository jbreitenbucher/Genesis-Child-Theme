<?php
/**
 * Admin
 *
 * This file contains any functions related to the admin interface
 *
 * @package     jb
 * @author      Jon Breitenbucher <jon@breitenbucher.net>
 * @copyright   Copyright (c) 2012, Jon Breitenbucher
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 *
 */

/**
 * Register Theme Settings
 *
 * @author Jon Breitenbucher
 */

function jb_register_settings() {
    register_setting( JB_SETTINGS_FIELD, JB_SETTINGS_FIELD );
    add_option( JB_SETTINGS_FIELD , jb_option_defaults() );
    add_settings_section('jb_recipe','Recipe Settings', 'jb_recipe_section_text', JB_SETTINGS_FIELD );
    add_settings_field('jb_num_posts', 'Recipes Per Page', 'jb_num_posts_setting', JB_SETTINGS_FIELD , 'jb_recipe');
    add_settings_section('jb_general','General Settings', 'jb_general_section_text', JB_SETTINGS_FIELD );
    //add_settings_field('jb_linkedin', 'LinkedIn Username', 'jb_linkedin_setting', JB_SETTINGS_FIELD , 'jb_general');
    //add_settings_field('jb_twitter', 'Twitter Username', 'jb_twitter_setting', JB_SETTINGS_FIELD , 'jb_general');
    add_settings_field('jb_blog_cat', 'News/Blog Category', 'jb_blog_cat_setting', JB_SETTINGS_FIELD , 'jb_general');
}

/**
 * Set Theme Options Defaults
 *
 * @author Jon Breitenbucher
 */

function jb_option_defaults() {
        $arr = array(
        'jb_recipe_posts_per_page' => 15,
        'jb_blog_cat' => 'articles'
    );
    return $arr;
}

/**
 * Options Description
 *
 * @author Jon Breitenbucher
 */

function jb_recipe_section_text() {
    echo '<p>These options control various aspects of the display of recipe content.</p>';
}

/**
 * Staff Posts Per Page
 *
 * @author Jon Breitenbucher
 */

function jb_num_posts_setting() {
    echo '<p>' . _e( 'Enter the number of staff you would like to display in staff listings.', 'jb' ) . '</p>';
    echo "<input type='text' name='" . JB_SETTINGS_FIELD . "[jb_recipe_posts_per_page]' size='10' value='". genesis_get_option( 'jb_recipe_posts_per_page', JB_SETTINGS_FIELD ). "' />";
}

/**
 * General Options Description
 *
 * @author Jon Breitenbucher
 */

function jb_general_section_text() {
    echo '<p>These options control various aspects of the display of social networking and news links.</p>';
}

/**
 * Blog Category
 *
 * @author Jon Breitenbucher
 */

function jb_blog_cat_setting() {
    echo '<p>' . _e( 'Enter the name or slug used for the news/blog category.', 'jb' ) . '</p>';
    echo "<input type='text' name='" . JB_SETTINGS_FIELD . "[jb_blog_cat]' size='20' value='" . genesis_get_option( 'jb_blog_cat', JB_SETTINGS_FIELD ) . "' />";
}

/**
 * LinkedIn
 *
 * @author Jon Breitenbucher
 */

function jb_linkedin_setting() {
    echo '<p>' . _e( 'Enter your LinkedIn username.', 'jb' ) . '</p>';
    echo "<input type='text' name='" . JB_SETTINGS_FIELD . "[jb_linkedin]' size='20' value='" . genesis_get_option( 'jb_linkedin', JB_SETTINGS_FIELD ) . "' />";
}

/**
 * Twitter
 *
 * @author Jon Breitenbucher
 */

function jb_twitter_setting() {
    echo '<p>' . _e( 'Enter your Twitter username.', 'jb' ) . '</p>';
    echo "<input type='text' name='" . JB_SETTINGS_FIELD . "[jb_twitter]' size='20' value='" . genesis_get_option( 'jb_twitter', JB_SETTINGS_FIELD ) . "' />";
}

/**
 * Reset
 *
 * @author Jon Breitenbucher
 */

function jb_reset() {
    if ( ! isset( $_REQUEST['page'] ) || 'jb-settings' != $_REQUEST['page'] )
        return;

    if ( genesis_get_option( 'reset', JB_SETTINGS_FIELD ) ) {
        update_option( JB_SETTINGS_FIELD, jb_option_defaults() );
        wp_redirect( admin_url( 'admin.php?page=jb-settings&reset=true' ) );
        exit;
    }
}

/**
 * Admin Notices
 *
 * @author Jon Breitenbucher
 */

function jb_notices() {
    if ( ! isset( $_REQUEST['page'] ) || 'jb-settings' != $_REQUEST['page'] )
        return;

    if ( isset( $_REQUEST['reset'] ) && 'true' == $_REQUEST['reset'] ) {
        echo '<div id="message" class="updated"><p><strong>' . __( 'Settings Reset', 'jb' ) . '</strong></p></div>';
    }
    elseif ( isset( $_REQUEST['settings-updated'] ) && 'true' == $_REQUEST['settings-updated'] ) {  
        echo '<div id="message" class="updated"><p><strong>' . __( 'Settings Saved', 'jb' ) . '</strong></p></div>';
    }
}

/**
 * Add Theme Options Menu
 *
 * @author Jon Breitenbucher
 */

function jb_add_menu() {
    add_submenu_page('genesis', __('Recipes','jb'), __('Recipe Settings','jb'), 'manage_options', 'jb-settings', 'jb_admin_page' );
}

/**
 * Theme Options Page
 *
 * @author Jon Breitenbucher
 */

function jb_admin_page() { ?>
    
    <div class="wrap">
        <?php screen_icon( 'options-general' ); ?>  
        <h2><?php echo esc_html( get_admin_page_title() ); ?></h2>
        
        <form method="post" action="options.php">
        <?php settings_fields( JB_SETTINGS_FIELD ); // important! ?>
        <?php do_settings_sections( JB_SETTINGS_FIELD ); ?>
        
            <div class="bottom-buttons">
                <input type="submit" class="button-primary" value="<?php _e('Save Settings', 'genesis') ?>" />
                <input type="submit" class="button-highlighted" name="<?php echo JB_SETTINGS_FIELD; ?>[reset]" value="<?php _e('Reset Settings', 'genesis'); ?>" />
            </div>
            
        </form>
    </div>
    
<?php }

/**
 * Sanitize Theme Options
 *
 * @author Jon Breitenbucher
 */

function jb_recipe_sanitization_filters() {
    genesis_add_option_filter( 'no_html', JB_SETTINGS_FIELD, array( 'jb_recipe_posts_per_page' ) );
    genesis_add_option_filter( 'no_html', JB_SETTINGS_FIELD, array( 'jb_blog_cat' ) );
    //genesis_add_option_filter( 'no_html', JB_SETTINGS_FIELD, array( 'jb_linkedin' ) );
    //genesis_add_option_filter( 'no_html', JB_SETTINGS_FIELD, array( 'jb_twitter' ) );
}