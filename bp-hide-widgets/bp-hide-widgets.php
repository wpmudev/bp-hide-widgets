<?php
/*
Plugin Name: BP Hide Widgets
Version: 1.0.3
Plugin URI: http://premium.wpmudev.org/project/buddypress-hide-widgets
Description: Adds the ability to choose which Buddypress widgets should only be available to the main blog.
Author: Aaron Edwards (Incsub)
Author URI: http://uglyrobot.com
Network: true
WDP ID: 113

Copyright 2009-2011 Incsub (http://incsub.com)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License (Version 2 - GPLv2) as published by
the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/


//------------------------------------------------------------------------//

//---Config---------------------------------------------------------------//

//------------------------------------------------------------------------//


//------------------------------------------------------------------------//

//---Hook-----------------------------------------------------------------//

//------------------------------------------------------------------------//

add_action( 'plugins_loaded', 'bp_hide_widgets_localization' );
add_action( 'bp_core_admin_screen', 'bp_hide_widgets_admin' );
add_action( 'bp_register_widgets', 'bp_hide_widgets_unregister', 20 );

//------------------------------------------------------------------------//

//---Functions------------------------------------------------------------//

//------------------------------------------------------------------------//

function bp_hide_widgets_localization() {
  // Load up the localization file if we're using WordPress in a different language
	// Place it in this plugin's "languages" folder and name it "bp_hide_widgets-[value in wp-config].mo"
	load_plugin_textdomain( 'bp_hide_widgets', FALSE, '/bp-hide-widgets/languages' );
}

function bp_hide_widgets_unregister() {

  //ignore main site
  if (is_main_site())
    return;

  if ( bp_get_option( 'BP_Blogs_Recent_Posts_Widget', '0' ) )
    add_action('widgets_init', create_function('', 'return unregister_widget("BP_Blogs_Recent_Posts_Widget");'), 21 ); //run after bp
	
	if ( bp_get_option( 'BP_Groups_Widget', '0' ) )
    add_action('widgets_init', create_function('', 'return unregister_widget("BP_Groups_Widget");'), 21 ); //run after bp

	if ( bp_get_option( 'BP_Core_Members_Widget', '0' ) )
    add_action('widgets_init', create_function('', 'return unregister_widget("BP_Core_Members_Widget");'), 21 ); //run after bp

	if ( bp_get_option( 'BP_Core_Whos_Online_Widget', '0' ) )
    add_action('widgets_init', create_function('', 'return unregister_widget("BP_Core_Whos_Online_Widget");'), 21 ); //run after bp

	if ( bp_get_option( 'BP_Core_Recently_Active_Widget', '0' ) )
    add_action('widgets_init', create_function('', 'return unregister_widget("BP_Core_Recently_Active_Widget");'), 21 ); //run after bp

}

//------------------------------------------------------------------------//

//---Output Functions-----------------------------------------------------//

//------------------------------------------------------------------------//

function bp_hide_widgets_admin() {
  ?>
	<h2><?php _e( 'Hide Widgets', 'bp_hide_widgets' ) ?></h2>
	<span class="description"><?php _e( 'Chose which BuddyPress widgets should only be available to the main site.', 'bp_hide_widgets' ) ?></span>
	<table class="form-table">
		<tbody>
			<tr>
				<th scope="row"><?php _e( 'Recent Networkwide Posts', 'bp_hide_widgets' ); ?></th>
				<td>
					<input type="radio" name="bp-admin[BP_Blogs_Recent_Posts_Widget]"<?php checked( bp_get_option( 'BP_Blogs_Recent_Posts_Widget', '0' ) ); ?>value="1" /> <?php _e( 'Main', 'bp_hide_widgets' ) ?> &nbsp;
					<input type="radio" name="bp-admin[BP_Blogs_Recent_Posts_Widget]"<?php checked( !bp_get_option( 'BP_Blogs_Recent_Posts_Widget', '0' ) ); ?>value="0" /> <?php _e( 'All', 'bp_hide_widgets' ) ?>
				</td>
			</tr>
			<tr>
				<th scope="row"><?php _e( 'Groups', 'bp_hide_widgets' ) ?></th>
				<td>
					<input type="radio" name="bp-admin[BP_Groups_Widget]"<?php checked( bp_get_option( 'BP_Groups_Widget', '0' ) ); ?>value="1" /> <?php _e( 'Main', 'bp_hide_widgets' ) ?> &nbsp;
					<input type="radio" name="bp-admin[BP_Groups_Widget]"<?php checked( !bp_get_option( 'BP_Groups_Widget', '0' ) ); ?>value="0" /> <?php _e( 'All', 'bp_hide_widgets' ) ?>
				</td>
			</tr>
			<tr>
				<th scope="row"><?php _e( 'Members', 'bp_hide_widgets' ) ?></th>
				<td>
					<input type="radio" name="bp-admin[BP_Core_Members_Widget]"<?php checked( bp_get_option( 'BP_Core_Members_Widget', '0' ) ); ?>value="1" /> <?php _e( 'Main', 'bp_hide_widgets' ) ?> &nbsp;
					<input type="radio" name="bp-admin[BP_Core_Members_Widget]"<?php checked( !bp_get_option( 'BP_Core_Members_Widget', '0' ) ); ?>value="0" /> <?php _e( 'All', 'bp_hide_widgets' ) ?>
				</td>
			</tr>
			<tr>
				<th scope="row"><?php _e( "Who's Online Avatars", 'bp_hide_widgets' ) ?></th>
				<td>
					<input type="radio" name="bp-admin[BP_Core_Whos_Online_Widget]"<?php checked( bp_get_option( 'BP_Core_Whos_Online_Widget', '0' ) ); ?>value="1" /> <?php _e( 'Main', 'bp_hide_widgets' ) ?> &nbsp;
					<input type="radio" name="bp-admin[BP_Core_Whos_Online_Widget]"<?php checked( !bp_get_option( 'BP_Core_Whos_Online_Widget', '0' ) ); ?>value="0" /> <?php _e( 'All', 'bp_hide_widgets' ) ?>
				</td>
			</tr>
			<tr>
				<th scope="row"><?php _e( 'Recently Active Member Avatars', 'bp_hide_widgets' ) ?></th>
				<td>
					<input type="radio" name="bp-admin[BP_Core_Recently_Active_Widget]"<?php checked( bp_get_option( 'BP_Core_Recently_Active_Widget', '0' ) ); ?>value="1" /> <?php _e( 'Main', 'bp_hide_widgets' ) ?> &nbsp;
					<input type="radio" name="bp-admin[BP_Core_Recently_Active_Widget]"<?php checked( !bp_get_option( 'BP_Core_Recently_Active_Widget', '0' ) ); ?>value="0" /> <?php _e( 'All', 'bp_hide_widgets' ) ?>
				</td>
			</tr>
		</tbody>
	</table>
  <?php
}


//------------------------------------------------------------------------//

//---Support Functions----------------------------------------------------//

//------------------------------------------------------------------------//



///////////////////////////////////////////////////////////////////////////
/* -------------------- Update Notifications Notice -------------------- */
if ( !function_exists( 'wdp_un_check' ) ) {
  add_action( 'admin_notices', 'wdp_un_check', 5 );
  add_action( 'network_admin_notices', 'wdp_un_check', 5 );
  function wdp_un_check() {
    if ( !class_exists( 'WPMUDEV_Update_Notifications' ) && current_user_can( 'install_plugins' ) )
      echo '<div class="error fade"><p>' . __('Please install the latest version of <a href="http://premium.wpmudev.org/project/update-notifications/" title="Download Now &raquo;">our free Update Notifications plugin</a> which helps you stay up-to-date with the most stable, secure versions of WPMU DEV themes and plugins. <a href="http://premium.wpmudev.org/wpmu-dev/update-notifications-plugin-information/">More information &raquo;</a>', 'wpmudev') . '</a></p></div>';
  }
}
/* --------------------------------------------------------------------- */
?>