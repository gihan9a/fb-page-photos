<?php
// start session
if ( !session_id() )
	session_start();

/**
 * Plugin configuration page
 */
function fbpp_plugin_page(){
	
	global $page_id;
	
	if(isset($_GET['fbpp_action']) && $_GET['fbpp_action'] == 'fetch_albums'){
		$albums_fetched_data = fbpp_fetch_albums($_GET['page_id']);
		
		//list them
		if(!isset($albums_fetched_data->error)){
			// store in session
			$_SESSION['fbpp_sess_albums'] = $albums_fetched_data;
			
			$albums = array();
			foreach($albums_fetched_data->data as $album){
				$al = $album;
				$al->fbpp_coverphoto = fbpp_fetch_photo($album->cover_photo);
				$albums[] = $al;
			}
			// Add to display
			include dirname( __FILE__ ) . '/list_albums_view.php';
		}else{
			// TODO error
		}
	}elseif(isset($_GET['fbpp_action']) && $_GET['fbpp_action']== 'save_fetched'){
		// drop currents
		fbpp_drop_current_albums();
		
		$ses_albums = $_SESSION['fbpp_sess_albums'];
		foreach($ses_albums->data as $album){
			$album_db_id = fbpp_save_album($album);
			
			$photos = fbpp_fetch_album_photos($album->id);
			
			// save photos in each album
			if(!isset($photos->error)){
				foreach($photos->data as $photo){
					fbpp_insert_photo($photo, $album_db_id);
				}
				echo '<div class="updated"><p><strong>'._e('Options saved.' ).'</strong></p></div>';
				
			}else{
				// TODO error of getting photos of each album
			}
		}
	}else{
		include dirname(__FILE__).'/config-form.php';
		
		$db_albums = fbpp_get_all_albums();
		if($db_albums){
			$albums = array();
			foreach($db_albums as $album){
				$al = json_decode($album->data);
				$al->fbpp_coverphoto = fbpp_get_photo($album->cover_photo);
				$albums[] = $al;
			}
			
			include dirname( __FILE__ ) . '/list_albums_view.php';
		}
	}
}

/**
 * Adds link for configuring plugin
 * This will add a link under plugins 
 */
function fbpp_plugin_page_options(){
	add_plugins_page( "Facebook Page Photos Configuration", "FBPP Config", 1, 'fbpp', 'fbpp_plugin_page');
}
add_action( 'admin_menu', 'fbpp_plugin_page_options' );
