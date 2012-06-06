<?php
/**
 * @package       3d-nitle-innovation
 * @author        Orthogonal Creations <jon@breitenbucher.net>
 * @copyright     Copyright (c) 2012, NITLE
 * @license       http://opensource.org/licenses/gpl-2.0.php GNU Public License
 *
 */

/**
 * Loop Setup
 *
 * This setup function attaches all of the loop-specific functions 
 * to the correct hooks and filters. All the functions themselves
 * are defined below this setup function.
 *
 */

add_action('genesis_before','threed_single_loop_setup');
function threed_single_loop_setup() {
    
    // Remove Before Loop
    remove_action('genesis_before_loop','genesis_do_before_loop' );
    
    // Remove Post Info
    remove_action('genesis_before_post_content', 'genesis_post_info');
    
    // Customize Post Content
    remove_action('genesis_post_content','genesis_do_post_content');
    add_action('genesis_post_content','threed_recipe_post_content');
    
    // Remove Title, After Title, and Post Image
    remove_action('genesis_post_title', 'genesis_do_post_title');
    remove_action('genesis_after_post_title', 'genesis_do_after_post_title');
    remove_action('genesis_post_content', 'genesis_do_post_image');
    
    // Remove Post Meta
    remove_action('genesis_after_post_content', 'genesis_post_meta');
    
    // Customize After Endwhile
    remove_action('genesis_after_endwhile','genesis_do_after_endwhile');
    remove_action('genesis_after_endwhile', 'genesis_posts_nav');
    add_action('genesis_after_endwhile', 'threed_recipe_after_endwhile');
}

/**
 * Customize Post Content
 *
 * @author Orthogonal Creations
 */

function threed_recipe_post_content() {
    global $post;
		$tax = get_the_term_list($post->ID, 'area', '', ', ', '');
		$context = genesis_get_custom_field('jb_context_wysiwyg');
		$learning = genesis_get_custom_field('jb_learning_goals_text');
		$ingredients = genesis_get_custom_field('jb_ingredients_text');
		$tools = genesis_get_custom_field('jb_tools_text');
		$method = genesis_get_custom_field('jb_method_wysiwig');
		$variations = genesis_get_custom_field('jb_variations_wysiwig');
		$pitfalls = genesis_get_custom_field('jb_pitfalls_wysiwig');
		$example = genesis_get_custom_field('jb_example_file');
        printf('<h1 class="title">%s</h1> by <span class="author">%s</span>', genesis_get_custom_field('jb_recipe_title_text'), genesis_get_custom_field('jb_author_name_text') );
    echo '<div class="post-inner">';
        if ( has_post_thumbnail() ) {
            echo '<div class="featured-image">';
                the_post_thumbnail('recipe-single');
            echo '</div> <!--end .featured-image -->';
                echo '<div class="recipe-content">';
					echo '<h2>Area/Topic</h2>';
						echo $tax;
					echo '<h2>Context</h2>';
						echo $context;
					echo '<h2>Learning Goals</h2>';
						echo $learning;
					echo '<h2>Required Ingredients</h2>';
						echo $ingredients;
					echo '<h2>Required Tools</h2>';
						echo $tools;
					echo '<h2>Method</h2>';
						echo $method;
					echo '<h2>Variations</h2>';
						echo $variations;
					echo '<h2>Pitfalls</h2>';
						echo $pitfalls;
					echo '<h2>Example</h2>';
						echo $example;
                echo '</div> <!--end .recipe-content -->';
        } else {
           	echo '<div class="recipe-content">';
				echo '<h2>Area/Topic</h2>';
					echo $tax;
				echo '<h2>Context</h2>';
					echo $context;
				echo '<h2>Learning Goals</h2>';
					echo $learning;
				echo '<h2>Required Ingredients</h2>';
					echo $ingredients;
				echo '<h2>Required Tools</h2>';
					echo $tools;
				echo '<h2>Method</h2>';
					echo $method;
				echo '<h2>Variations</h2>';
					echo $variations;
				echo '<h2>Pitfalls</h2>';
					echo $pitfalls;
				echo '<h2>Example</h2>';
					echo $example;
            echo '</div> <!--end .recipe-content -->';
        }
	echo '</div><!-- end .post-inner -->';
}

/**
 * Customize After Endwhile
 *
 * @author Orthogonal Creations
 */

function threed_recipe_after_endwhile() {
    echo '<div class="navigation">';
        echo '<div class="alignleft">';
            previous_posts_link('&larr; Previous');
        echo '</div>';
        echo '<div class="alignright">';
            next_posts_link('More &rarr;');
        echo '</div>';
    echo '</div>';
}

genesis();