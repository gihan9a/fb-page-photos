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
define('FBPP_WP_OPTION', 'fbpp_page_id');

require_once dirname(__FILE__) . '/functions.php';

/**
 * Main function to show the Facebook Page Photos
 */
function fbpp_show($atts) {
    if (isset($_GET['fbpp_album']) && ($db_photos = fbpp_get_album_photos($_GET['fbpp_album'])) != NULL) {
        $album_id = $_GET['fbpp_album'];
        // get album photos
        $db_photos = fbpp_get_album_photos($album_id);
        if($db_photos){
            $album = fbpp_get_album($album_id);
            $photos = array();
            foreach($db_photos as $photo){
                $foto = json_decode($photo->data);
                $photos[] = $foto;
            }
            $base_url = $_SERVER['REQUEST_URI'];
            // remove album id
            $album_base_url = substr($base_url, 0, (-1 + strpos($base_url, 'fbpp_album')));
            include dirname(__FILE__) . '/user_photos_view.php';
            
        }else{
            // no photos
        }
        
    } else {
        $db_albums = fbpp_get_all_albums();
        if($db_albums){
            $albums = array();
            foreach ($db_albums as $album) {
                // skip hidden albums
                if(!$album->show)
                    continue;
                $al = json_decode($album->data);
                $al->db_id = $album->id;
                $al->show = $album->show;
                // insert cover photo from db
                $al->fbpp_coverphoto = fbpp_get_photo($album->coverphoto_fbid);
                
                $albums[] = $al;
            }
            
            // get base usr
            $base_url = $_SERVER['REQUEST_URI'];
            if(strpos($base_url, '?')){
                $base_url .= '&fbpp_album=';
            }else{
                $base_url .= '?fbpp_album=';
            }
            
            include dirname(__FILE__) . '/user_albums_view.php';
        }else{
            
        }
    }
}

add_shortcode('fbpp', 'fbpp_show');

function fbpp_styles(){
    echo '<link rel="stylesheet" type="text/css" href="'.plugins_url(basename(dirname(__FILE__)).'/fbpp.css').'" />';
}

add_action('wp_head', 'fbpp_styles');

if (is_admin()) {
    require_once dirname(__FILE__) . '/admin.php';
}
