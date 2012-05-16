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
    //add_settings_field('mcedc_linkedin', 'LinkedIn Username', 'mcedc_linkedin_setting', MCEDC_SETTINGS_FIELD , 'mcedc_general');
    //add_settings_field('mcedc_twitter', 'Twitter Username', 'mcedc_twitter_setting', MCEDC_SETTINGS_FIELD , 'mcedc_general');
    add_settings_field('jb_blog_cat', 'News/Blog Category', 'jb_blog_cat_setting', JB_SETTINGS_FIELD , 'jb_general');
}

/**
 * Set Theme Options Defaults
 *
 * @author The Pedestal Group
 */

function mcedc_option_defaults() {
        $arr = array(
        'jb_recipe_posts_per_page' => 15,
        'jb_blog_cat' => 'articles'
    );
    return $arr;
}

/**
 * Options Description
 *
 * @author The Pedestal Group
 */

function mcedc_section_text() {
    echo '<p>These options control various aspects of the display of staff content for the Dorman Farrell theme.</p>';
}

/**
 * Staff Posts Per Page
 *
 * @author The Pedestal Group
 */

function mcedc_num_posts_setting() {
    echo '<p>' . _e( 'Enter the number of staff you would like to display in staff listings.', 'mcedc' ) . '</p>';
    echo "<input type='text' name='" . MCEDC_SETTINGS_FIELD . "[mcedc_staff_posts_per_page]' size='10' value='". genesis_get_option( 'mcedc_staff_posts_per_page', MCEDC_SETTINGS_FIELD ). "' />";
}

/**
 * General Options Description
 *
 * @author The Pedestal Group
 */

function mcedc_general_section_text() {
    echo '<p>These options control various aspects of the display of social networking and news links.</p>';
}

/**
 * Blog Category
 *
 * @author The Pedestal Group
 */

function mcedc_blog_cat_setting() {
    echo '<p>' . _e( 'Enter the name or slug used for the news/blog category.', 'mcedc' ) . '</p>';
    echo "<input type='text' name='" . MCEDC_SETTINGS_FIELD . "[mcedc_blog_cat]' size='20' value='" . genesis_get_option( 'mcedc_blog_cat', MCEDC_SETTINGS_FIELD ) . "' />";
}

/**
 * LinkedIn
 *
 * @author The Pedestal Group
 */

function mcedc_linkedin_setting() {
    echo '<p>' . _e( 'Enter your LinkedIn username.', 'mcedc' ) . '</p>';
    echo "<input type='text' name='" . MCEDC_SETTINGS_FIELD . "[mcedc_linkedin]' size='20' value='" . genesis_get_option( 'mcedc_linkedin', MCEDC_SETTINGS_FIELD ) . "' />";
}

/**
 * Twitter
 *
 * @author The Pedestal Group
 */

function mcedc_twitter_setting() {
    echo '<p>' . _e( 'Enter your Twitter username.', 'mcedc' ) . '</p>';
    echo "<input type='text' name='" . MCEDC_SETTINGS_FIELD . "[mcedc_twitter]' size='20' value='" . genesis_get_option( 'mcedc_twitter', MCEDC_SETTINGS_FIELD ) . "' />";
}

/**
 * Reset
 *
 * @author The Pedestal Group
 */

function mcedc_reset() {
    if ( ! isset( $_REQUEST['page'] ) || 'mcedc-settings' != $_REQUEST['page'] )
        return;

    if ( genesis_get_option( 'reset', MCEDC_SETTINGS_FIELD ) ) {
        update_option( MCEDC_SETTINGS_FIELD, mcedc_option_defaults() );
        wp_redirect( admin_url( 'admin.php?page=mcedc-settings&reset=true' ) );
        exit;
    }
}

/**
 * Admin Notices
 *
 * @author The Pedestal Group
 */

function mcedc_notices() {
    if ( ! isset( $_REQUEST['page'] ) || 'mcedc-settings' != $_REQUEST['page'] )
        return;

    if ( isset( $_REQUEST['reset'] ) && 'true' == $_REQUEST['reset'] ) {
        echo '<div id="message" class="updated"><p><strong>' . __( 'Settings Reset', 'mcedc' ) . '</strong></p></div>';
    }
    elseif ( isset( $_REQUEST['settings-updated'] ) && 'true' == $_REQUEST['settings-updated'] ) {  
        echo '<div id="message" class="updated"><p><strong>' . __( 'Settings Saved', 'mcedc' ) . '</strong></p></div>';
    }
}

/**
 * Add Theme Options Menu
 *
 * @author The Pedestal Group
 */

function mcedc_add_menu() {
    add_submenu_page('genesis', __('MCEDC','mcedc'), __('MCEDC Settings','mcedc'), 'manage_options', 'mcedc-settings', 'mcedc_admin_page' );
}

/**
 * Theme Options Page
 *
 * @author The Pedestal Group
 */

function mcedc_admin_page() { ?>
    
    <div class="wrap">
        <?php screen_icon( 'options-general' ); ?>  
        <h2><?php echo esc_html( get_admin_page_title() ); ?></h2>
        
        <form method="post" action="options.php">
        <?php settings_fields( MCEDC_SETTINGS_FIELD ); // important! ?>
        <?php do_settings_sections( MCEDC_SETTINGS_FIELD ); ?>
        
            <div class="bottom-buttons">
                <input type="submit" class="button-primary" value="<?php _e('Save Settings', 'genesis') ?>" />
                <input type="submit" class="button-highlighted" name="<?php echo MCEDC_SETTINGS_FIELD; ?>[reset]" value="<?php _e('Reset Settings', 'genesis'); ?>" />
            </div>
            
        </form>
    </div>
    
<?php }

/**
 * Sanitize Theme Options
 *
 * @author The Pedestal Group
 */

function mcedc_staff_sanitization_filters() {
    genesis_add_option_filter( 'no_html', MCEDC_SETTINGS_FIELD, array( 'mcedc_staff_posts_per_page' ) );
    genesis_add_option_filter( 'no_html', MCEDC_SETTINGS_FIELD, array( 'mcedc_blog_cat' ) );
    genesis_add_option_filter( 'no_html', MCEDC_SETTINGS_FIELD, array( 'mcedc_linkedin' ) );
    genesis_add_option_filter( 'no_html', MCEDC_SETTINGS_FIELD, array( 'mcedc_twitter' ) );
}