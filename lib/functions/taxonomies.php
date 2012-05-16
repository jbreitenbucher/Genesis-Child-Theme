<?php
/**
 * Taxonomies
 *
 * This file registers any custom taxonomies
 *
 * @package     jb
 * @author      Jon Breitenbucher <jon@breitenbucher.net>
 * @copyright   Copyright (c) 2012, Jon Breitenbucher
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 *
 */


/**
 * Create Role Taxonomy
 *
 * @link http://codex.wordpress.org/Function_Reference/register_taxonomy
 * @author Jon Breitenbucher
 *
 */

function jb_create_area_taxonomy(){
    $labels = array(
        'name' => _x( 'Areas', 'taxonomy general name' ),
        'singular_name' => _x( 'Area', 'taxonomy singular name' ),
        'search_items' =>  __( 'Search Areas' ),
        'popular_items' => __( 'Popular Areas' ),
        'all_items' => __( 'All Areas' ),
        'parent_item' => null,
        'parent_item_colon' => null,
        'edit_item' => __( 'Edit Area' ), 
        'update_item' => __( 'Update Area' ),
        'add_new_item' => __( 'Add New Area' ),
        'new_item_name' => __( 'New Area Name' ),
        'separate_items_with_commas' => __( 'Separate areas with commas' ),
        'add_or_remove_items' => __( 'Add or remove areas' ),
        'choose_from_most_used' => __( 'Choose from the most used areas' ),
        'menu_name' => __( 'Area' ),
    );

    register_taxonomy(  
        'area',
        'recipe',
        array(
            'hierarchical' => false,
            'labels' => $labels,
            'public'=>true,
            'show_ui'=>true,
            'query_var' => true,
            'rewrite' => array( 'slug' => 'area', 'with_front' => false ),
        )
    );
}
add_action( 'init', 'jb_create_area_taxonomy', 0 );