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
 
remove_action('genesis_loop', 'genesis_do_loop');
add_action('genesis_loop', 'single_topic_loop');
 
function single_topic_loop() {
?>
 
<div id="container">
	<div id="content" role="main">

		<?php do_action( 'bbp_template_notices' ); ?>

		<?php if ( bbp_user_can_view_forum( array( 'forum_id' => bbp_get_topic_forum_id() ) ) ) : ?>

			<?php while ( have_posts() ) : the_post(); ?>

				<div id="bbp-topic-wrapper-<?php bbp_topic_id(); ?>" class="bbp-topic-wrapper">
					<h1 class="entry-title"><?php bbp_topic_title(); ?></h1>
					<div class="entry-content">

						<?php bbp_get_template_part( 'bbpress/content', 'single-topic' ); ?>

					</div>
				</div><!-- #bbp-topic-wrapper-<?php bbp_topic_id(); ?> -->

			<?php endwhile; ?>

		<?php elseif ( bbp_is_forum_private( bbp_get_topic_forum_id(), false ) ) : ?>

			<?php bbp_get_template_part( 'bbpress/feedback', 'no-access' ); ?>

		<?php endif; ?>

	</div><!-- #content -->
</div><!-- #container -->
 
<?php
}
genesis();
?>