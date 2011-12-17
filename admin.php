<?php
// start session
if ( !session_id() )
	session_start();

/**
 * Adds link for configuring plugin
 * This will add a link under plugins 
 */
function fbpp_plugin_page_options(){
	add_plugins_page( "Facebook Page Phots Configuration", "FBPP Config", 1, 'fbpp', 'fbpp_plugin_page');
}
add_action( 'admin_menu', 'fbpp_plugin_page_options' );
