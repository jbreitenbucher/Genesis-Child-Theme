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
add_action('genesis_loop', 'archive_topic_loop');
 
function archive_topic_loop() {
?>
 
<div id="container">
	<div id="content" role="main">

		<?php do_action( 'bbp_template_notices' ); ?>

		<div id="topic-front" class="bbp-topics-front">
			<h1 class="entry-title"><?php bbp_topic_archive_title(); ?></h1>
			<div class="entry-content">

				<?php bbp_get_template_part( 'bbpress/content', 'archive-topic' ); ?>

			</div>
		</div><!-- #topics-front -->

	</div><!-- #content -->
</div><!-- #container -->
 
<?php
}
genesis();
?>