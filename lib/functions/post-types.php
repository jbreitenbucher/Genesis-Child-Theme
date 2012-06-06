<?php
/**
 * Post Types
 *
 * This file registers any custom post types
 *
 * @package     jb
 * @author      Jon Breitenbucher <jon@breitenbucher.net>
 * @copyright   Copyright (c) 2012, Jon Breitenbucher
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 *
 */

/**
 * Create Recipe post type
 *
 * @link http://codex.wordpress.org/Function_Reference/register_post_type
 * @author Jon Breitenbucher
 *
 */

function jb_create_recipe_post_type() {
    $labels = array(
        'name' => _x('Recipe', 'post type general name'),
        'singular_name' => _x('Recipe', 'post type singular name'),
        'add_new' => _x('Add New', 'recipe'),
        'add_new_item' => __('Add New Recipe'),
        'edit_item' => __('Edit Recipe'),
        'new_item' => __('New Recipe'),
        'all_items' => __('All Recipes'),
        'view_item' => __('View Recipe'),
        'search_items' => __('Search Recipes'),
        'not_found' =>  __('No recipe found'),
        'not_found_in_trash' => __('No recipe found in Trash'), 
        'parent_item_colon' => '',
        'menu_name' => 'Recipes'
    );
    $args = array(
        'labels' => $labels,
        'description' => 'A post type for entering recipe information.',
        'public' => true,
        'publicly_queryable' => true,
		'exclude_from_search' => false,
        'show_ui' => true,
        'query_var' => true,
        'hierarchical' => false,
        'supports' => array('thumbnail'),
        'rewrite' => array('slug' => 'recipe'),
        'has_archive' => 'recipes',
    );
    register_post_type('recipe',$args);
}
add_action( 'init', 'jb_create_recipe_post_type' );
