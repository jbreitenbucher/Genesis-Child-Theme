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
add_action('genesis_loop', 'taxonomy_topic_tag_loop');
 
function taxonomy_topic_tag_loop() {
?>
 
<div id="container">
	<div id="content" role="main">

		<?php do_action( 'bbp_template_notices' ); ?>

		<div id="topic-tag" class="bbp-topic-tag">
			<h1 class="entry-title"><?php printf( __( 'Topic Tag: %s', 'bbpress' ), '<span>' . bbp_get_topic_tag_name() . '</span>' ); ?></h1>

			<div class="entry-content">

				<?php bbp_breadcrumb(); ?>

				<?php bbp_topic_tag_description(); ?>

				<?php do_action( 'bbp_template_before_topic_tag' ); ?>

				<?php if ( bbp_has_topics() ) : ?>

					<?php bbp_get_template_part( 'bbpress/pagination', 'topics'    ); ?>

					<?php bbp_get_template_part( 'bbpress/loop',       'topics'    ); ?>

					<?php bbp_get_template_part( 'bbpress/pagination', 'topics'    ); ?>

				<?php else : ?>

					<?php bbp_get_template_part( 'bbpress/feedback',   'no-topics' ); ?>

				<?php endif; ?>

				<?php do_action( 'bbp_template_after_topic_tag' ); ?>

			</div>
		</div><!-- #topic-tag -->
	</div><!-- #content -->
</div><!-- #container -->
 
<?php
}
genesis();
?>