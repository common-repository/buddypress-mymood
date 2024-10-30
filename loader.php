<?php 
/**
Plugin Name: BuddyPress MyMood
Plugin URI: http://webgarb.com/?BuddyPress+MyMood
Description: Lets your BuddyPress member share there mood with there activity post.
Version: 1.0
Author: Ayush
Author URI: http://webgarb.com
**/

define("BP_MYMOOD_VERSION",1.0);
define("BP_MYMOOD_PATH",plugins_url("",__FILE__));
define("BP_MYMOOD_DIR",str_replace("\/","/",dirname(__FILE__)) );

function bp_mymood_init() {
	
	require( dirname( __FILE__ ) . '/buddypress-mymood.php' );
	
}
add_action( 'bp_include', 'bp_mymood_init' );

?>