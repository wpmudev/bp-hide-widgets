<?php
/*
Plugin Name: BuddyPress Hide Widgets
Version: 1.0.5
Plugin URI: http://premium.wpmudev.org/project/buddypress-hide-widgets/
Description: Adds the ability to choose which Buddypress widgets should only be available to the main site.
Author: Aaron Edwards (Incsub)
Author URI: http://uglyrobot.com
Network: true
Textdomain: bp_hide_widgets
WDP ID: 113

Copyright 2009-2014 Incsub (http://incsub.com)

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
add_action( 'bp_register_admin_settings', 'bp_hide_widgets_register_settings' );
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
	
	if ( bp_get_option( 'BP_Core_Friends_Widget', '0' ) )
    add_action('widgets_init', create_function('', 'return unregister_widget("BP_Core_Friends_Widget");'), 21 ); //run after bp

	if ( bp_get_option( 'BP_Core_Login_Widget', '0' ) )
    add_action('widgets_init', create_function('', 'return unregister_widget("BP_Core_Login_Widget");'), 21 ); //run after bp

	if ( bp_get_option( 'BP_Messages_Sitewide_Notices_Widget', '0' ) )
    add_action('widgets_init', create_function('', 'return unregister_widget("BP_Messages_Sitewide_Notices_Widget");'), 21 ); //run after bp
}

//------------------------------------------------------------------------//

//---Output Functions-----------------------------------------------------//

//------------------------------------------------------------------------//

function bp_hide_widgets_register_settings() {
	// Add the main section
	add_settings_section( 'bp_hide_widgets', __( 'Hide Widgets', 'bp_hide_widgets' ), 'bp_hide_widgets_admin_section', 'buddypress' );
	add_settings_field( 'BP_Blogs_Recent_Posts_Widget', __( 'Recent Networkwide Posts', 'bp_hide_widgets' ), 'bp_hide_widgets_admin1', 'buddypress', 'bp_hide_widgets' );
	add_settings_field( 'BP_Groups_Widget', __( 'Groups', 'bp_hide_widgets' ), 'bp_hide_widgets_admin2', 'buddypress', 'bp_hide_widgets' );
	add_settings_field( 'BP_Core_Members_Widget', __( 'Members', 'bp_hide_widgets' ), 'bp_hide_widgets_admin3', 'buddypress', 'bp_hide_widgets' );
	add_settings_field( 'BP_Core_Whos_Online_Widget', __( "Who's Online Avatars", 'bp_hide_widgets' ), 'bp_hide_widgets_admin4', 'buddypress', 'bp_hide_widgets' );
	add_settings_field( 'BP_Core_Recently_Active_Widget', __( 'Recently Active Member Avatars', 'bp_hide_widgets' ), 'bp_hide_widgets_admin5', 'buddypress', 'bp_hide_widgets' );
	add_settings_field( 'BP_Core_Friends_Widget', __( 'Friends', 'bp_hide_widgets' ), 'bp_hide_widgets_admin6', 'buddypress', 'bp_hide_widgets' );
	add_settings_field( 'BP_Core_Login_Widget', __( 'Login', 'bp_hide_widgets' ), 'bp_hide_widgets_admin7', 'buddypress', 'bp_hide_widgets' );
	add_settings_field( 'BP_Messages_Sitewide_Notices_Widget', __( 'Sitewide Notices', 'bp_hide_widgets' ), 'bp_hide_widgets_admin8', 'buddypress', 'bp_hide_widgets' );
	
	register_setting( 'buddypress', 'BP_Blogs_Recent_Posts_Widget', 'intval');
	register_setting( 'buddypress', 'BP_Groups_Widget', 'intval');
	register_setting( 'buddypress', 'BP_Core_Members_Widget', 'intval');
	register_setting( 'buddypress', 'BP_Core_Whos_Online_Widget', 'intval');
	register_setting( 'buddypress', 'BP_Core_Recently_Active_Widget', 'intval');
	register_setting( 'buddypress', 'BP_Core_Friends_Widget', 'intval');
	register_setting( 'buddypress', 'BP_Core_Login_Widget', 'intval');
	register_setting( 'buddypress', 'BP_Messages_Sitewide_Notices_Widget', 'intval');
}

function bp_hide_widgets_admin_section() {
	?><span class="description"><?php _e( 'Chose which BuddyPress widgets should only be available to the main site.', 'bp_hide_widgets' ) ?></span><?php
}

function bp_hide_widgets_admin1() {
  ?>
	<label><input type="radio" name="BP_Blogs_Recent_Posts_Widget"<?php checked( bp_get_option( 'BP_Blogs_Recent_Posts_Widget', '0' ) ); ?>value="1" /> <?php _e( 'Main', 'bp_hide_widgets' ) ?></label> &nbsp;
	<label><input type="radio" name="BP_Blogs_Recent_Posts_Widget"<?php checked( !bp_get_option( 'BP_Blogs_Recent_Posts_Widget', '0' ) ); ?>value="0" /> <?php _e( 'All', 'bp_hide_widgets' ) ?></label>
  <?php
}

function bp_hide_widgets_admin2() {
  ?>
	<label><input type="radio" name="BP_Groups_Widget"<?php checked( bp_get_option( 'BP_Groups_Widget', '0' ) ); ?>value="1" /> <?php _e( 'Main', 'bp_hide_widgets' ) ?></label> &nbsp;
	<label><input type="radio" name="BP_Groups_Widget"<?php checked( !bp_get_option( 'BP_Groups_Widget', '0' ) ); ?>value="0" /> <?php _e( 'All', 'bp_hide_widgets' ) ?></label>
  <?php
}

function bp_hide_widgets_admin3() {
  ?>
	<label><input type="radio" name="BP_Core_Members_Widget"<?php checked( bp_get_option( 'BP_Core_Members_Widget', '0' ) ); ?>value="1" /> <?php _e( 'Main', 'bp_hide_widgets' ) ?></label> &nbsp;
	<label><input type="radio" name="BP_Core_Members_Widget"<?php checked( !bp_get_option( 'BP_Core_Members_Widget', '0' ) ); ?>value="0" /> <?php _e( 'All', 'bp_hide_widgets' ) ?></label>
  <?php
}

function bp_hide_widgets_admin4() {
  ?>
	<label><input type="radio" name="BP_Core_Whos_Online_Widget"<?php checked( bp_get_option( 'BP_Core_Whos_Online_Widget', '0' ) ); ?>value="1" /> <?php _e( 'Main', 'bp_hide_widgets' ) ?></label> &nbsp;
	<label><input type="radio" name="BP_Core_Whos_Online_Widget"<?php checked( !bp_get_option( 'BP_Core_Whos_Online_Widget', '0' ) ); ?>value="0" /> <?php _e( 'All', 'bp_hide_widgets' ) ?></label>
  <?php
}

function bp_hide_widgets_admin5() {
  ?>
	<input type="radio" name="BP_Core_Recently_Active_Widget"<?php checked( bp_get_option( 'BP_Core_Recently_Active_Widget', '0' ) ); ?>value="1" /> <?php _e( 'Main', 'bp_hide_widgets' ) ?></label> &nbsp;
	<input type="radio" name="BP_Core_Recently_Active_Widget"<?php checked( !bp_get_option( 'BP_Core_Recently_Active_Widget', '0' ) ); ?>value="0" /> <?php _e( 'All', 'bp_hide_widgets' ) ?></label>
  <?php
}

function bp_hide_widgets_admin6() {
  ?>
	<input type="radio" name="BP_Core_Friends_Widget"<?php checked( bp_get_option( 'BP_Core_Friends_Widget', '0' ) ); ?>value="1" /> <?php _e( 'Main', 'bp_hide_widgets' ) ?></label> &nbsp;
	<input type="radio" name="BP_Core_Friends_Widget"<?php checked( !bp_get_option( 'BP_Core_Friends_Widget', '0' ) ); ?>value="0" /> <?php _e( 'All', 'bp_hide_widgets' ) ?></label>
  <?php
}

function bp_hide_widgets_admin7() {
  ?>
	<input type="radio" name="BP_Core_Login_Widget"<?php checked( bp_get_option( 'BP_Core_Login_Widget', '0' ) ); ?>value="1" /> <?php _e( 'Main', 'bp_hide_widgets' ) ?></label> &nbsp;
	<input type="radio" name="BP_Core_Login_Widget"<?php checked( !bp_get_option( 'BP_Core_Login_Widget', '0' ) ); ?>value="0" /> <?php _e( 'All', 'bp_hide_widgets' ) ?></label>
  <?php
}

function bp_hide_widgets_admin8() {
  ?>
	<input type="radio" name="BP_Messages_Sitewide_Notices_Widget"<?php checked( bp_get_option( 'BP_Messages_Sitewide_Notices_Widget', '0' ) ); ?>value="1" /> <?php _e( 'Main', 'bp_hide_widgets' ) ?></label> &nbsp;
	<input type="radio" name="BP_Messages_Sitewide_Notices_Widget"<?php checked( !bp_get_option( 'BP_Messages_Sitewide_Notices_Widget', '0' ) ); ?>value="0" /> <?php _e( 'All', 'bp_hide_widgets' ) ?></label>
  <?php
}

//------------------------------------------------------------------------//

//---Support Functions----------------------------------------------------//

//------------------------------------------------------------------------//

//load dashboard notice
global $wpmudev_notices;
$wpmudev_notices[] = array( 'id'=> 113,'name'=> 'BuddyPress Hide Widgets', 'screens' => array( 'settings_page_bp-settings', 'settings_page_bp-settings-network' ) );
include_once( dirname(__FILE__) . '/dash-notice/wpmudev-dash-notification.php' );