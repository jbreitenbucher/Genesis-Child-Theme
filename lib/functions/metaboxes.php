<?php
/**
 * Metaboxes
 *
 * This file registers any custom metaboxes
 *
 * @package     jb
 * @author      Jon Breitenbucher <jon@breitenbucher.net>
 * @copyright   Copyright (c) 2012, Jon Breitenbucher
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 *
 */

/**
 * Create Recipe Metabox
 *
 * @link https://github.com/jaredatch/Custom-Metaboxes-and-Fields-for-WordPress
 * @author Jon Breitenbucher
 *
 */

function jb_create_metaboxes( $meta_boxes ) {
    $prefix = 'jb_'; // start with an underscore to hide fields from custom fields list
    $meta_boxes[] = array(
        'id' => 'jb_info_metabox',
        'title' => 'Recipe Information',
        'pages' => array('recipe'), // post type
        'context' => 'normal',
        'priority' => 'low',
        'show_names' => true, // Show field names on the left
        'fields' => array(
            array(
                'name' => 'Author(s)',
                'desc' => '',
                'id' => $prefix . 'author_name_text',
                'type' => 'text'
            ),
            array(
                'name' => 'Recipe Title',
                'desc' => '',
                'id' => $prefix . 'recipe_title_text',
                'type' => 'text'
            ),
            array(
                'name' => 'Learning Goals',
                'desc' => 'What are the expected learning outcomes?',
                'id' => $prefix . 'learning_goals_text',
                'type' => 'text'
            ),
            array(
                'name' => 'Context',
                'desc' => 'When would you use this recipe?',
                'id' => $prefix . 'context_wysiwyg',
                'type' => 'wysiwyg',
				'options' => array(
                    'wpautop' => true, // use wpautop?
                    'media_buttons' => false, // show insert/upload button(s)
                    'textarea_rows' => get_option('default_post_edit_rows', 10), // rows="..."
                ),
            ),
            array(
                'name' => 'Ingredients',
                'desc' => 'What does this recipe require?',
                'id' => $prefix . 'ingredients_text',
                'type' => 'text'
            ),
			array(
                'name' => 'Tools',
                'desc' => 'What software/hardware does this recipe require?',
                'id' => $prefix . 'tools_text',
                'type' => 'text'
            ),
            array(
                'name' => 'Method',
                'desc' => 'Give a step-by-step description of implementation.',
                'id' => $prefix . 'method_wysiwig',
                'type' => 'wysiwyg',
				'options' => array(
                    'wpautop' => true, // use wpautop?
                    'media_buttons' => false, // show insert/upload button(s)
                    'textarea_rows' => get_option('default_post_edit_rows', 10), // rows="..."
                ),
            ),
			array(
                'name' => 'Variations',
                'desc' => 'What are some potential variations on your recipe?',
                'id' => $prefix . 'variations_wysiwig',
                'type' => 'wysiwyg',
				'options' => array(
                    'wpautop' => true, // use wpautop?
                    'media_buttons' => false, // show insert/upload button(s)
                    'textarea_rows' => get_option('default_post_edit_rows', 10), // rows="..."
                ),
            ),
			array(
                'name' => 'Pitfalls',
                'desc' => 'What should people watch for when using this recipe?',
                'id' => $prefix . 'pitfalls_wysiwig',
                'type' => 'wysiwyg',
				'options' => array(
                    'wpautop' => true, // use wpautop?
                    'media_buttons' => false, // show insert/upload button(s)
                    'textarea_rows' => get_option('default_post_edit_rows', 10), // rows="..."
                ),
            ),
			array(
				'name' => 'Finished Example',
				'desc' => 'Enter an URL or upload an image or PDF.',
				'id'   => $prefix . 'example_file',
				'type' => 'file',
			),
            array(
                'name' => 'Area',
                'desc' => 'To which areas does this recipe belong?',
                'id' => $prefix . 'area_taxonomy_multicheck',
                'taxonomy' => 'area', //Enter Taxonomy Slug
                'type' => 'taxonomy_multicheck',    
            ),
        ),
    );
    
    return $meta_boxes;
}

add_filter( 'cmb_meta_boxes' , 'jb_create_metaboxes' );
 
 
/**
 * Initialize Metabox Class
 * see /lib/metabox/example-functions.php for more information
 *
 */
function jb_initialize_cmb_meta_boxes() {
    if ( !class_exists( 'cmb_Meta_Box' ) ) {
        require_once( get_stylesheet_directory() . '/lib/metabox/init.php' );
    }
}

add_action( 'init', 'jb_initialize_cmb_meta_boxes', 9999 );
