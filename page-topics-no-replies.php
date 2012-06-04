<?php
/**
 * Template Name: bbPress - Topics (No Replies)
 *
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
 
remove_action('genesis_loop', 'genesis_do_loop');
add_action('genesis_loop', 'page_topics_no_replies_loop');
 
function page_topics_no_replies_loop() {
?>
 
<div id="container">
	<div id="content" role="main">

		<?php do_action( 'bbp_template_notices' ); ?>

		<?php while ( have_posts() ) : the_post(); ?>

			<div id="topics-front" class="bbp-topics-front">
				<h1 class="entry-title"><?php the_title(); ?></h1>
				<div class="entry-content">

					<?php the_content(); ?>

					<?php bbp_breadcrumb(); ?>

					<?php bbp_set_query_name( 'bbp_no_replies' ); ?>

					<?php if ( bbp_has_topics( array( 'meta_key' => '_bbp_reply_count', 'meta_value' => '1', 'meta_compare' => '<', 'orderby' => 'date', 'show_stickies' => false ) ) ) : ?>

						<?php bbp_get_template_part( 'bbpress/pagination', 'topics'    ); ?>

						<?php bbp_get_template_part( 'bbpress/loop',       'topics'    ); ?>

						<?php bbp_get_template_part( 'bbpress/pagination', 'topics'    ); ?>

					<?php else : ?>

						<?php bbp_get_template_part( 'bbpress/feedback',   'no-topics' ); ?>

					<?php endif; ?>

					<?php bbp_reset_query_name(); ?>

				</div>
			</div><!-- #topics-front -->

		<?php endwhile; ?>

	</div><!-- #content -->
</div><!-- #container -->
 
<?php
}
genesis();
?>