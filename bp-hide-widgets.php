<?php
/*
Plugin Name: BP Hide Widgets
Version: 1.0.1
Plugin URI: http://incsub.com
Description: Adds the ability to choose which Buddypress widgets should only be available to the main blog. Must be activated site-wide.
Author: Aaron Edwards at uglyrobot.com (for Incsub)
Author URI: http://uglyrobot.com
Site Wide Only: true

Copyright 2009 Incsub (http://incsub.com)

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
add_action( 'bp_core_admin_screen_fields', 'bp_hide_widgets_admin' );
add_action( 'bp_init', 'bp_hide_widgets_unregister' );

//------------------------------------------------------------------------//

//---Functions------------------------------------------------------------//

//------------------------------------------------------------------------//

function bp_hide_widgets_localization() {
  // Load up the localization file if we're using WordPress in a different language
	// Place it in this plugin's "languages" folder and name it "bp_hide_widgets-[value in wp-config].mo"
	load_plugin_textdomain( 'bp_hide_widgets', FALSE, '/bp-hide-widgets/languages' );
}

function bp_hide_widgets_unregister() {
  global $current_site, $blog_id;

  //ignore main blog - not necessarily blog_id 1 with multiple sites
  if ($current_site->blog_id == $blog_id)
    return;
  
  $bp_hide_widgets = get_site_option('bp_hide_widgets');

  if (is_array($bp_hide_widgets) && count($bp_hide_widgets)) {
    foreach ($bp_hide_widgets as $widget)
      add_action('widgets_init', create_function('', 'return unregister_widget('.$widget.');'), 21 ); //run after bp
  }

}

//------------------------------------------------------------------------//

//---Output Functions-----------------------------------------------------//

//------------------------------------------------------------------------//

function bp_hide_widgets_admin() {
  $bp_hide_widgets = (array)get_site_option('bp_hide_widgets');
  ?>
  <tr>
		<th scope="row"><?php _e( 'Hide Widgets', 'bp_hide_widgets' ) ?></th>
		<td>
			<p><?php _e( 'Chose which buddypress widgets should only be available to the main blog.', 'bp_hide_widgets' ) ?></p>
      
      <input name="bp-admin[bp_hide_widgets]" value="" type="hidden" />
			<label><input name="bp-admin[bp_hide_widgets][]" value="BP_Activity_Widget" type="checkbox" <?php echo (in_array('BP_Activity_Widget', $bp_hide_widgets)) ? 'checked="checked"' : '' ?> />&nbsp;<?php _e( 'Site Wide Activity', 'bp_hide_widgets' ) ?></label><br />
			<label><input name="bp-admin[bp_hide_widgets][]" value="BP_Blogs_Recent_Posts_Widget" type="checkbox" <?php echo (in_array('BP_Blogs_Recent_Posts_Widget', $bp_hide_widgets)) ? 'checked="checked"' : '' ?> />&nbsp;<?php _e( 'Recent Site Wide Posts', 'bp_hide_widgets' ) ?></label><br />
			<label><input name="bp-admin[bp_hide_widgets][]" value="BP_Groups_Widget" type="checkbox" <?php echo (in_array('BP_Groups_Widget', $bp_hide_widgets)) ? 'checked="checked"' : '' ?> />&nbsp;<?php _e( 'Groups', 'bp_hide_widgets' ) ?></label><br />
			<label><input name="bp-admin[bp_hide_widgets][]" value="BP_Core_Welcome_Widget" type="checkbox" <?php echo (in_array('BP_Core_Welcome_Widget', $bp_hide_widgets)) ? 'checked="checked"' : '' ?> />&nbsp;<?php _e( 'Welcome', 'bp_hide_widgets' ) ?></label><br />
			<label><input name="bp-admin[bp_hide_widgets][]" value="BP_Core_Members_Widget" type="checkbox" <?php echo (in_array('BP_Core_Members_Widget', $bp_hide_widgets)) ? 'checked="checked"' : '' ?> />&nbsp;<?php _e( 'Members', 'bp_hide_widgets' ) ?></label><br />
			<label><input name="bp-admin[bp_hide_widgets][]" value="BP_Core_Whos_Online_Widget" type="checkbox" <?php echo (in_array('BP_Core_Whos_Online_Widget', $bp_hide_widgets)) ? 'checked="checked"' : '' ?> />&nbsp;<?php _e( 'Who\'s Online Avatars', 'bp_hide_widgets' ) ?></label><br />
			<label><input name="bp-admin[bp_hide_widgets][]" value="BP_Core_Recently_Active_Widget" type="checkbox" <?php echo (in_array('BP_Core_Recently_Active_Widget', $bp_hide_widgets)) ? 'checked="checked"' : '' ?> />&nbsp;<?php _e( 'Recently Active Member Avatars', 'bp_hide_widgets' ) ?></label><br />
    </td>
	</tr>
  <?php
}


//------------------------------------------------------------------------//

//---Support Functions----------------------------------------------------//

//------------------------------------------------------------------------//



?>