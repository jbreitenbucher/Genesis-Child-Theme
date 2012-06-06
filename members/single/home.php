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
add_action('genesis_loop', 'members_single_loop');
 
function members_single_loop() {
?>

<div id="container">
	<div id="content">

		<?php do_action( 'bp_before_member_home_content' ) ?>

		<div id="item-header">
			<?php locate_template( array( 'members/single/member-header.php' ), true ) ?>
		</div><!-- #item-header -->

		<div id="item-nav">
			<div class="item-list-tabs no-ajax" id="object-nav">
				<ul>
					<?php bp_get_displayed_user_nav() ?>

					<?php do_action( 'bp_members_directory_member_types' ) ?>
				</ul>
			</div>
		</div><!-- #item-nav -->

		<div id="item-body">
			<?php do_action( 'bp_before_member_body' ) ?>

			<?php if ( bp_is_user_activity() || !bp_current_component() ) : ?>
				<?php locate_template( array( 'members/single/activity.php' ), true ) ?>

			<?php elseif ( bp_is_user_blogs() ) : ?>
				<?php locate_template( array( 'members/single/blogs.php' ), true ) ?>

			<?php elseif ( bp_is_user_friends() ) : ?>
				<?php locate_template( array( 'members/single/friends.php' ), true ) ?>

			<?php elseif ( bp_is_user_groups() ) : ?>
				<?php locate_template( array( 'members/single/groups.php' ), true ) ?>

			<?php elseif ( bp_is_user_messages() ) : ?>
				<?php locate_template( array( 'members/single/messages.php' ), true ) ?>

			<?php elseif ( bp_is_user_profile() ) : ?>
				<?php locate_template( array( 'members/single/profile.php' ), true ) ?>

			<?php endif; ?>

			<?php do_action( 'bp_after_member_body' ) ?>

		</div><!-- #item-body -->

		<?php do_action( 'bp_after_member_home_content' ) ?>

	</div><!-- #content -->
</div><!-- #container -->

<?php
}
genesis();
?>