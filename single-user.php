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
add_action('genesis_loop', 'single_user_loop');
 
function single_user_loop() {
?>
 
<div id="container">
	<div id="content" role="main">

		<div id="bbp-user-<?php bbp_current_user_id(); ?>" class="bbp-single-user">
			<div class="entry-content">

				<?php bbp_get_template_part( 'bbpress/content', 'single-user' ); ?>

			</div><!-- .entry-content -->
		</div><!-- #bbp-user-<?php bbp_current_user_id(); ?> -->

	</div><!-- #content -->
</div><!-- #container -->
 
<?php
}
genesis();
?>