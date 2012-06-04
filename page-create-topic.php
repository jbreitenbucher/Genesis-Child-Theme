<?php
/**
 * Template Name: bbPress - Create Topic
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
add_action('genesis_loop', 'page_create_topic_loop');
 
function page_create_topic_loop() {
?>
 
<div id="container">
	<div id="content" role="main">

		<?php do_action( 'bbp_template_notices' ); ?>

		<?php while ( have_posts() ) : the_post(); ?>

			<div id="bbp-new-topic" class="bbp-new-topic">
				<h1 class="entry-title"><?php the_title(); ?></h1>
				<div class="entry-content">

					<?php the_content(); ?>

					<?php bbp_get_template_part( 'bbpress/form', 'topic' ); ?>

				</div>
			</div><!-- #bbp-new-topic -->

		<?php endwhile; ?>

	</div><!-- #content -->
</div><!-- #container -->
 
<?php
}
genesis();
?>