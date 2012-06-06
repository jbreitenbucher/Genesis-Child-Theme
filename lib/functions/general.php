<?php
/**
 * Functions
 *
 * This file registers any custom functions
 *
 * @package     jb
 * @author      Jon Breitenbucher <jon@breitenbucher.net>
 * @copyright   Copyright (c) 2012, Jon Breitenbucher
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 *
 */

/**
 * Remove Menu Items
 *
 * Remove unused menu items by adding them to the array.
 * See the commented list of menu items for reference.
 *
 */

function jb_remove_menus_by_role () {
    global $menu;
    global $current_user;
    $user_roles = $current_user->roles;
    $user_role = array_shift($user_roles);
    if($user_role == 'author') {
        $restricted = array(__('Dashboard'), __('Posts'), __('Media'), __('Links'), __('Pages'), __('Appearance'), __('Tools'), __('Users'), __('Settings'), __('Comments'), __('Plugins'), __('Genesis'), __('Forums'), __('Topics'), __('Replies'));
        end ($menu);
        while (prev($menu)){
            $value = explode(' ',$menu[key($menu)][0]);
            if(in_array($value[0] != NULL?$value[0]:"" , $restricted)){unset($menu[key($menu)]);}
        } //end while
    }//end if
}
add_action('admin_menu', 'jb_remove_menus_by_role');

/**
 * Customize Menu Order
 *
 * @param array $menu_ord. Current order.
 * @return array $menu_ord. New order.
 *
 */

function jb_custom_menu_order( $menu_ord ) {
    if ( !$menu_ord ) return true;
    return array(
        'index.php', // this represents the dashboard link
        'edit.php?post_type=page', //the page tab
        'edit.php', //the posts tab
        'edit-comments.php', // the comments tab
        'upload.php', // the media manager
    );
}
add_filter( 'custom_menu_order', 'jb_custom_menu_order' );
add_filter( 'menu_order', 'jb_custom_menu_order' );

/**
 * Add a Role column on the Staff admin page
 *
 * @param array $posts_columns
 * @return array $new_posts_columns
 *
 * @author Jon Breitenbucher
 *
 */

function jb_add_area_column_to_recipe_list( $posts_columns ) {
    if (!isset($posts_columns['author'])) {
        $new_posts_columns = $posts_columns;
    } else {
        $new_posts_columns = array();
        $index = 0;
        foreach($posts_columns as $key => $posts_column) {
            if ($key=='author') {
            $new_posts_columns['area'] = null;
            }
            $new_posts_columns[$key] = $posts_column;
        }
    }
    $new_posts_columns['area'] = 'Areas';
    $new_posts_columns['author'] = __('Author');
    return $new_posts_columns;
}

/**
 * Display areas for a recipe in the Areas column
 *
 * @param $column_id, $post_id
 * @return $areas
 *
 * @author Jon Breitenbucher
 *
 */

function jb_show_area_column_for_recipe_list( $column_id,$post_id ) {
    global $typenow;
    if ($typenow=='recipe') {
        $taxonomy = 'area';
        switch ($column_id) {
        case 'area':
            $areas = get_the_terms($post_id,$taxonomy);
            if (is_array($areas)) {
                foreach($areas as $key => $area) {
                    $edit_link = get_term_link($area,$taxonomy);
                    $areas[$key] = '<a href="'.$edit_link.'">' . $area->name . '</a>';
                }
                echo implode(' | ',$areas);
            }
            break;
        }
    }
}
add_filter( 'manage_recipe_posts_columns', 'jb_add_area_column_to_recipe_list' );
add_filter('manage_staff_posts_custom_column', 'jb_show_area_column_for_recipe_list', 10, 2);

/*
Description: Adds a taxonomy filter in the admin list page for a custom post type.
Written for: http://wordpress.stackexchange.com/posts/582/
By: Mike Schinkel - http://mikeschinkel.com/custom-workpress-plugins
*/

/**
 * Setup drop down for filtering according to role.
 *
 * @author chodorowicz
 *
 */
function jb_restrict_recipe_by_area() {
global $typenow;
    $args=array( 'public' => true, '_builtin' => false ); 
    $post_types = get_post_types($args);
    if ( in_array($typenow, $post_types) ) {
        $filters = get_object_taxonomies($typenow);
        foreach ($filters as $tax_slug) {
            $tax_obj = get_taxonomy($tax_slug);
            wp_dropdown_categories(array(
                'show_option_all' => __('Show All '.$tax_obj->label ),
                'taxonomy' => $tax_slug,
                'name' => $tax_obj->name,
                'orderby' => 'term_order',
                'selected' => $_GET[$tax_obj->query_var],
                'hierarchical' => $tax_obj->hierarchical,
                'show_count' => false,
                'hide_empty' => true
                )
            );
        }
    }
}
add_action('restrict_manage_posts','jb_restrict_recipe_by_area');

/**
 * Convert taxonomy ID to slug
 *
 * @param array $query
 * @return array $var
 * @author chodorowicz
 *
 */
function jb_convert_area_id_to_taxonomy_term_in_query($query) {
global $pagenow;
    global $typenow;
        if ($pagenow=='edit.php') {
            $filters = get_object_taxonomies($typenow);
                foreach ($filters as $tax_slug) {
                    $var = &$query->query_vars[$tax_slug];
                        if ( isset($var) ) {
                            $term = get_term_by('id',$var,$tax_slug);
                            $var = $term->slug;
                        }
                }
        }
}
add_filter('parse_query','jb_convert_area_id_to_taxonomy_term_in_query');

/**
 * Register the Areas column as sortable
 *
 * @param array $columns
 * @return array $columns
 * @author Jon Breitenbucher
 *
 */
function jb_area_column_register_sortable( $columns ) {
    $columns['area'] = 'area';
 
    return $columns;
}
add_filter( 'manage_edit-staff_sortable_columns', 'jb_area_column_register_sortable' );

/**
 * Set up orderby area
 *
 * @param array $vars
 * @return array $vars
 * @author Jon Breitenbucher
 *
 */
function jb_area_column_orderby( $vars ) {
    if ( isset( $vars['orderby'] ) && 'area' == $vars['orderby'] ) {
        $vars = array_merge( $vars, array(
            'meta_key' => 'jb_area_taxonomy_select',
            'orderby' => 'meta_value'
        ) );
    }
 
    return $vars;
}
add_filter( 'request', 'jb_area_column_orderby' );

/**
 * Customize posts_per_page on recipe archive pages
 *
 * @param array $query
 * @return array $query
 *
 * @author Jon Breitenbucher
 *
 */

function jb_change_recipe_size($query) {
    if ( $query->is_main_query() && !is_admin() && is_post_type_archive('recipe') ){ // Make sure it is a archive page
        $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
        $query->set( 'posts_per_page', genesis_get_option('jb_recipe_posts_per_page', JB_SETTINGS_FIELD ) );
        $query->set('paged', $paged); // Set the post archive to be paged
    }
}
add_filter('pre_get_posts', 'jb_change_recipe_size'); // Hook our custom function onto the request filter

/**
 * Customize posts_per_page on area taxonomy pages
 *
 * @param $value
 *
 * @author Jon Breitenbucher
 *
 */

function jb_tax_filter_posts_per_page( $value ) {
    if (!is_admin()) {
        return (is_tax('area')) ? genesis_get_option('jb_recipe_posts_per_page', JB_SETTINGS_FIELD ) : $value;
    }
}
add_filter( 'option_posts_per_page', 'jb_tax_filter_posts_per_page' );

/**
 * Customize recipe post type icon
 *
 * @author Jon Breitenbucher
 *
 */

function set_recipe_icon() {
    global $post_type;
    ?>
    <style>
    <?php if (($_GET['post_type'] == 'recipe') || ($post_type == 'recipe')) : ?>
    #icon-edit { background:transparent url('<?php echo get_bloginfo('url');?>/wp-admin/images/icons32.png') no-repeat -600px -5px; }
    <?php endif; ?>
 
    #adminmenu #menu-posts-staff div.wp-menu-image{background:transparent url('<?php echo get_bloginfo('url');?>/wp-admin/images/menu.png') no-repeat scroll -300px -33px;}
    #adminmenu #menu-posts-staff:hover div.wp-menu-image,#adminmenu #menu-posts-staff.wp-has-current-submenu div.wp-menu-image{background:transparent url('<?php echo get_bloginfo('url');?>/wp-admin/images/menu.png') no-repeat scroll -300px -1px;}      
        </style>
        <?php
}
add_action('admin_head', 'set_recipe_icon');

/**
 * Remove support for Title and WYSIWYG editor on recipe post type
 *
 * @author Jon Breitenbucher
 *
 */

function jb_recipe_custom_init() {
    remove_post_type_support('recipe', 'editor');
    remove_post_type_support('recipe', 'title');
}
add_action('init', 'jb_recipe_custom_init');

/**
 * Remove the role taxonomy from the staff post type screen
 *
 * @author Jon Breitenbucher
 *
 */

function jb_remove_custom_taxonomy() {
    remove_meta_box( 'tagsdiv-area', 'recipe', 'side' );
}
add_action( 'admin_menu', 'jb_remove_custom_taxonomy' );

/**
 * Set the title from a custom field in the data entry for the recipe post type
 *
 * @param $recipe_title
 * @return $recipe_title
 *
 * @author Jon Breitenbucher
 *
 */

function jb_save_new_title($recipe_title) {
      if ($_POST['post_type'] == 'recipe') :
           $rtitle = $_POST['jb_recipe_title_text'];
           $recipe_title = $rtitle;
      endif;
      return $recipe_title;
}
add_filter('title_save_pre', 'jb_save_new_title');

/**
 * Add filter to ensure the text Recipe, or recipe, is displayed
 * when user updates a recipe
 *
 * @param array $messages
 * @return array $messages
 *
 * @author Jon Breitenbucher
 *
 */

function jb_recipe_updated_messages( $messages ) {
  global $post, $post_ID;

  $messages['recipe'] = array(
    0 => '', // Unused. Messages start at index 1.
    1 => sprintf( __('Recipe updated. <a href="%s">View Recipe</a>'), esc_url( get_permalink($post_ID) ) ),
    2 => __('Custom field updated.'),
    3 => __('Custom field deleted.'),
    4 => __('Recipe updated.'),
    /* translators: %s: date and time of the revision */
    5 => isset($_GET['revision']) ? sprintf( __('Recipe restored to revision from %s'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
    6 => sprintf( __('Recipe published. <a href="%s">View recipe</a>'), esc_url( get_permalink($post_ID) ) ),
    7 => __('Recipe saved.'),
    8 => sprintf( __('Recipe submitted. <a target="_blank" href="%s">Preview recipe</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
    9 => sprintf( __('Recipe scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview recipe</a>'),
      // translators: Publish box date format, see http://php.net/date
      date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( get_permalink($post_ID) ) ),
    10 => sprintf( __('Recipe draft updated. <a target="_blank" href="%s">Preview recipe</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
  );

  return $messages;
}
add_filter('post_updated_messages', 'jb_recipe_updated_messages');

/**
 * Do not display child, grandchild, etc. posts when viewing a parent category
 * and order by title in ascending order unless on the home screen or designated
 * blog page
 *
 * @param array $query
 * @return modified $query
 *
 * @author Jon Breitenbucher
 *
 */

function jb_no_child_posts( $query) {
    global $wp_query;
    $id = $wp_query->get_queried_object_id();
    if ( !is_home() && !is_category( genesis_get_option( 'jb_blog_cat', JB_SETTINGS_FIELD ) ) ) {
        if ( $query->is_category ) {
            $query->set( 'category__in', array( $id ) );
            $query->set( 'orderby', 'title' );
            $query->set( 'order', 'asc' );
        }
        return $query;
    }
}
add_action('pre_get_posts', 'jb_no_child_posts');

/**
 * Customize the post info function
 *
 * @param $post_info
 * @return modified $post_info
 *
 * @author Jon Breitenbucher
 *
 */

function jb_post_info_filter($post_info) {
if (!is_page()) {
    $post_info = '[post_date] [post_edit]';
    return $post_info;
}}
add_filter( 'genesis_post_info', 'jb_post_info_filter' );

/**
 * Customize the next post link text
 *
 * @author Jon Breitenbucher
 *
 */

function jb_next_post_link_text(){
    $next = 'Next &rarr;';
    return $next;
}
add_filter('genesis_next_link_text','jb_next_post_link_text');

/**
 * Customize the previous post link text
 *
 * @author Jon Breitenbucher
 *
 */

function mcedc_previous_post_link_text(){
    $previous = '&larr; Previous';
    return $previous;
}
add_filter('genesis_prev_link_text','jb_previous_post_link_text');

/**
 * Remove Header Right Widget
 *
 * @author Jon Breitenbucher
 */

function jb_remove_sidebars() {
    unregister_sidebar( 'header-right' );
    unregister_sidebar( 'sidebar-alt' );
}

/**
 * Header
 *
 * @author Jon Breitenbucher
 */

function jb_header() {
        echo '<div id="search" class="widget widget_search">';
            echo '<div class="widget-wrap">';
				echo '<form method="get" id="searchform" action="'. get_bloginfo('url') . '/">';
				echo '<div><input type="text" name="s" id="s" class="s" value="What can we help you find?" onfocus="if(this.value==this.defaultValue)this.value=\'\';" onblur="if(this.value==\'\')this.value=this.defaultValue;"/>';
				echo '<input type="submit" id="searchsubmit" value="Search" class="button" />';
				echo '</div>';
				echo '</form>';
            echo '</div><!-- end .widget-wrap -->';
        echo '</div><!-- end #search -->';
		//$args = array( 'taxonomy' => 'area' );

		//$terms = get_terms('area', $args);

		//$count = count($terms); $i=0;
		//if ($count > 0) {
		    //$term_list = '<p class="my_term-archive">';
		    //foreach ($terms as $term) {
		        //$i++;
		    	//$term_list .= '<a href="/term-base/' . $term->slug . '" title="' . sprintf(__('View all post filed under %s', 'my_localization_domain'), $term->name) . '">' . $term->name . '</a>';
		    	//if ($count < 4) $term_list .= ' &middot; '; else $term_list .= '</p>';
		    //}
			echo '<div class="suggestions">';
		    	echo '<span class="suggestion-text">May we suggest:</span> information visualization, information evaluation, zotero, critically evaluating information';
			echo '</div><!-- end .suggestions -->';
		//}
}

/**
 * Amend breadcrumb arguments.
 *
 * @author Gary Jones
 * @link http://dev.studiopress.com/modify-breadcrumb-display.htm
 *
 * @param array $args Default breadcrumb arguments
 * @return array Amended breadcrumb arguments
 */
function jb_breadcrumb_args( $args ) {
    if ( is_post_type_archive('recipe') ) {
        $args['sep'] = ' &#8594; ';
        $args['labels']['author']        = 'Articles written by ';
            $args['labels']['category']      = ''; // Genesis 1.6 and later
            $args['labels']['tag']           = '';
            $args['labels']['date']          = 'Archives for ';
            $args['labels']['search']        = 'Search for ';
            $args['labels']['tax']           = '';
            $args['labels']['post_type']     = '';
            return $args;
    }
    elseif ( is_taxonomy('area') ) {
        $args['sep'] = ' &#8594; ';
            $args['labels']['author']        = 'Articles written by ';
            $args['labels']['category']      = ''; // Genesis 1.6 and later
            $args['labels']['tag']           = '';
            $args['labels']['date']          = 'Archives for ';
            $args['labels']['search']        = 'Search for ';
            $args['labels']['tax']           = '';
            $args['labels']['post_type']     = '';
            return $args;
    }
    else {
        $args['sep'] = ' &#8594; ';
        $args['labels']['author']        = 'Articles written by ';
            $args['labels']['category']      = ''; // Genesis 1.6 and later
            $args['labels']['tag']           = '';
            $args['labels']['date']          = 'Archives for ';
            $args['labels']['search']        = 'Search for ';
            $args['labels']['tax']           = '';
            $args['labels']['post_type']     = '';
        return $args;
    }
}

// Customize the credits
//add_filter('genesis_footer_creds_text', 'custom_footer_creds_text');
function custom_footer_creds_text($creds) {
    $creds = '&copy; ' . date("Y") . '   <a href="'. get_bloginfo( 'url' ) .'">Medina County Economic Development Corporation</a>   |   Content management systems by <a href="http://thepedestalgroup.com">The Pedestal Group</a>';
    return $creds;
}
// Customize the credits
//add_filter('genesis_footer_backtotop_text', 'custom_footer_backtotop_text');
function custom_footer_backtotop_text($backtotop) {
    $backtotop = '144 N. Broadway Street, Medina, OH 44256   |   330.722.9215   | ';
    return $backtotop;
}

function add_viewport_meta_tag() {
    echo '<meta name="viewport" content="width=device-width, initial-scale=1.0"/>';
}