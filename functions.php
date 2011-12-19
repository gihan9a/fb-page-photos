<?php
/**
 * Common functions are listed here
 */
 

/**
 * Curl implementation to get api data
 */
function curl_get_contents($url) {
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	$output = curl_exec($ch);
	curl_close($ch);
	return $output;
}

/* 
 * Fetch albums from facbook api
 */
function fbpp_fetch_albums($id){
	$url = FB_API_URI.'/'.$id.'/albums';
	$albums = curl_get_contents($url);
	return json_decode($albums);
}

/*
 * Fetch single photo from facebook api
 */
function fbpp_fetch_photo($id){
	$url = FB_API_URI.'/'.$id;
	$photo = curl_get_contents($url);
	return json_decode($photo);
}

/*
 * Fetch photos of albums from facebook api
 */
function fbpp_fetch_album_photos($id){
	$url = FB_API_URI.'/'.$id.'/photos';
	$photos = curl_get_contents($url);
	return json_decode($photos);
}


/**
 * Get all stored albums
 */
function fbpp_get_all_albums(){
	global $wpdb;
	return $wpdb->get_results("SELECT * FROM ".FBPP_ALBUM_TBL);
}

/**
 * Get photos of 
 */
function fbpp_get_photo($fbid, $data=TRUE){
	global $wpdb;
	$row = $wpdb->get_row("SELECT * FROM ".FBPP_PHOTO_TBL." WHERE fbid='$fbid'");
        if($row){
            return json_decode($row->data);
        }else{
            return null;
        }
}
