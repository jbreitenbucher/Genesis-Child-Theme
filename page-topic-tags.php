<?php
/**
 * Template Name: bbPress - Topic Tags
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
add_action('genesis_loop', 'page_topic_tags_loop');
 
function page_topic_tags_loop() {
?>
 
<div id="container">
	<div id="content" role="main">

		<?php do_action( 'bbp_template_notices' ); ?>

		<?php while ( have_posts() ) : the_post(); ?>

			<div id="bbp-topic-tags" class="bbp-topic-tags">
				<h1 class="entry-title"><?php the_title(); ?></h1>
				<div class="entry-content">

					<?php get_the_content() ? the_content() : _e( '<p>This is a collection of tags that are currently popular on our forums.</p>', 'bbpress' ); ?>

					<?php bbp_breadcrumb(); ?>

					<div id="bbp-topic-hot-tags">

						<?php wp_tag_cloud( array( 'smallest' => 9, 'largest' => 38, 'number' => 80, 'taxonomy' => bbp_get_topic_tag_tax_id() ) ); ?>

					</div>

				</div>
			</div><!-- #bbp-topic-tags -->

		<?php endwhile; ?>

	</div><!-- #content -->
</div><!-- #container -->
 
<?php
}
genesis();
?>