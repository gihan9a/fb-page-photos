<?php
/*
Plugin Name: FB Page Photos 
Plugin URI: https://github.com/gihanshp/fb-page-photos	
Description: This plugin will fetch and display of Facebook page's uploaded photo albums and photos
Version: 1.0
Author: Gihan Subhashana
Author URI: https://github.com/gihanshp
License: GPL
*/

define('FB_API_URI', 'https://graph.facebook.com');
define('FBPP_ALBUM_TBL', 'fbpp_album');
define('FBPP_PHOTO_TBL', 'fbpp_photo');

if ( is_admin() ){
	require_once dirname( __FILE__ ) . '/admin.php';;
}
