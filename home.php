<?php

add_action( 'genesis_meta', 'threed_home_genesis_meta' );
/**
 * Add widget support for homepage. If no widgets active, display the default loop.
 *
 */
function threed_home_genesis_meta() {
	
		remove_action( 'genesis_loop', 'genesis_do_loop' );
		add_action( 'genesis_loop', 'threed_home_loop_helper' );
		add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );

}

// Customize Header
if ( is_home() || is_front_page() ) {
    remove_action( 'genesis_header', 'genesis_do_header' );
    add_action( 'genesis_header', 'jb_header' );
}

/**
 * Display widget content for homepage sections.
 *
 */
function threed_home_loop_helper() {

	echo '<div class="widget-row clearfix">';
		
		if ( is_active_sidebar( 'home-left' ) ) {
			echo '<div class="home-left">';
				dynamic_sidebar( 'home-left' );
			echo '</div><!-- end .home-left -->';
		} else {
			echo '<div class="home-left">';
				echo '<h2>Newest Recipe</h2>';
				echo '<h4>Title</h4>';
				echo '<p>by Author</p>';
				echo '<p>Marfa mlkshk single-origin coffee you
				probably haven\'t heard of them. Austin
				you probably haven\'t heard of them
				cred, american apparel truffaut vinyl
				pour-over hoodie godard direct trade
				photo booth pop-up trust fund
				messenger bag swag. VHS fingerstache
				butcher, sustainable aesthetic
				gluten-free PBR keffiyeh whatever
				four loko mustache</p>';
			echo '</div><!-- end .home-left -->';
		}
	
		if ( is_active_sidebar( 'home-center' ) ) {
			echo '<div class="home-center">';
				dynamic_sidebar( 'home-center' );
			echo '</div><!-- end .home-center -->';
		} else {
			echo '<div class="home-center">';
				echo '<h2>Top Rated Recipe</h2>';
				echo '<h4>Title</h4>';
				echo '<p>by Author</p>';
				echo '<p>Marfa mlkshk single-origin coffee you
				probably haven\'t heard of them. Austin
				you probably haven\'t heard of them
				cred, american apparel truffaut vinyl
				pour-over hoodie godard direct trade
				photo booth pop-up trust fund
				messenger bag swag. VHS fingerstache
				butcher, sustainable aesthetic
				gluten-free PBR keffiyeh whatever
				four loko mustache</p>';
			echo '</div><!-- end .home-center -->';
		}
	
		if ( is_active_sidebar( 'home-right' ) ) {
			echo '<div class="home-right">';
				dynamic_sidebar( 'home-right' );
			echo '</div><!-- end .home-right -->';
		} else {
			echo '<div class="home-right">';
				echo '<h2>Recipe of the Day</h2>';
				echo '<h4>Title</h4>';
				echo '<p>by Author</p>';
				echo '<p>Marfa mlkshk single-origin coffee you
				probably haven\'t heard of them. Austin
				you probably haven\'t heard of them
				cred, american apparel truffaut vinyl
				pour-over hoodie godard direct trade
				photo booth pop-up trust fund
				messenger bag swag. VHS fingerstache
				butcher, sustainable aesthetic
				gluten-free PBR keffiyeh whatever
				four loko mustache</p>';
			echo '</div><!-- end .home-right -->';
		}
		
	echo '</div><!-- end .widget-row -->';
	
	echo '<div class="widget-row clearfix">';
		
		if ( is_active_sidebar( 'home-bottom' ) ) {
			echo '<div class="home-bottom">';
				dynamic_sidebar( 'home-bottom' );
			echo '</div><!-- end .home-bottom -->';
		} else {
			echo '<div class="home-bottom">';
				echo '<h2>Featured Recipe</h2>';
				echo '<h4>Title</h4>';
				echo '<p>by Author</p>';
				echo '<p>Marfa mlkshk single-origin coffee you
				probably haven\'t heard of them. Austin
				you probably haven\'t heard of them
				cred, american apparel truffaut vinyl
				pour-over hoodie godard direct trade
				photo booth pop-up trust fund
				messenger bag swag. VHS fingerstache
				butcher, sustainable aesthetic
				gluten-free PBR keffiyeh whatever
				four loko mustache</p>';
			echo '</div><!-- end .home-bottom -->';
		}
		
	echo '</div><!-- end .widget-row -->';

}

genesis();