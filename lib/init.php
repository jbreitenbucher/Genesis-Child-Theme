<?php
/**
 * This file controls the initialization of the theme
 *
 * @package     jb
 * @author      Jon Breitenbucher <jon@breitenbucher.net>
 * @copyright   Copyright (c) 2012, Jon Breitenbucher
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 *
 */

// Define our theme settings
define( 'JB_SETTINGS_FIELD', 'jb-settings' );

// Admin
require_once( get_stylesheet_directory() . '/lib/admin/admin.php' );

// Functions
require_once( get_stylesheet_directory() . '/bp/bp-functions.php' );
require_once( get_stylesheet_directory() . '/lib/functions/general.php' );
require_once( get_stylesheet_directory() . '/lib/functions/post-types.php' );
require_once( get_stylesheet_directory() . '/lib/functions/taxonomies.php' );
require_once( get_stylesheet_directory() . '/lib/functions/metaboxes.php' );
require_once( get_stylesheet_directory() . '/lib/functions/shortcodes.php' );