<?php

/**
 * Common functions are listed here
 */

/**
 *
 * @param type $url
 * @return type 
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

/**
 *
 * @param type $id
 * @return type 
 */
function fbpp_fetch_albums($id) {
    $url = FB_API_URI . '/' . $id . '/albums';
    $albums = curl_get_contents($url);
    return json_decode($albums);
}

/**
 *
 * @param type $id
 * @return type 
 */
function fbpp_fetch_photo($id) {
    $url = FB_API_URI . '/' . $id;
    $photo = curl_get_contents($url);
    return json_decode($photo);
}

/**
 *
 * @param type $id
 * @return type 
 */
function fbpp_fetch_album_photos($id) {
    $url = FB_API_URI . '/' . $id . '/photos';
    $photos = curl_get_contents($url);
    return json_decode($photos);
}

/**
 *
 * @global type $wpdb
 * @return type 
 */
function fbpp_get_all_albums() {
    global $wpdb;
    return $wpdb->get_results("SELECT * FROM " . FBPP_ALBUM_TBL);
}

/**
 *
 * @global type $wpdb
 * @param type $fbid
 * @param type $data
 * @return type 
 */
function fbpp_get_photo($fbid, $data=TRUE) {
    global $wpdb;
    $row = $wpdb->get_row("SELECT * FROM " . FBPP_PHOTO_TBL . " WHERE fbid='$fbid'");
    if ($data && $row) {
        return json_decode($row->data);
    }else
        return $row;
}

/**
 * Get photos of a single album
 * @global type $wpdb
 * @param type $album_id
 * @return type 
 */
function fbpp_get_album_photos($album_id) {
    global $wpdb;
    return $wpdb->get_results("SELECT * FROM " . FBPP_PHOTO_TBL . " WHERE album_id=$album_id");
}

/**
 * Get a single album info
 * @global type $wpdb
 * @param type $id
 * @return type 
 */
function fbpp_get_album($id, $data = TRUE) {
    global $wpdb;
    $album = $wpdb->get_row("SELECT * FROM " . FBPP_ALBUM_TBL . " WHERE id=$id");
    if ($data && $album) {
        return json_decode($album->data);
    } else {
        return $album;
    }
}

/**
 *
 * @global type $wpdb
 * @param type $album
 * @return type 
 */
function fbpp_save_album($album, $show=TRUE) {
    // first check album exists
    global $wpdb;
    $row = $wpdb->get_row("SELECT * FROM ".FBPP_ALBUM_TBL." WHERE fbid={$album->id}");
    if ($row) {
        // update info
        $data = array(
            'data' => json_encode($album),
            'coverphoto_fbid' => $album->cover_photo,
            'show' => $show,
        );
        $where = array(
            'id' => $row->id,
        );
        
        $wpdb->update(FBPP_ALBUM_TBL, $data, $where);

        return $row->id;
    } else {
        $album_data = array(
            'fbid' => $album->id,
            'data' => json_encode($album),
            'coverphoto_fbid' => $album->cover_photo,
            'show' => $show,
        );
        $wpdb->insert(FBPP_ALBUM_TBL, $album_data);
        return $wpdb->insert_id;
    }
}

/**
 *
 * @global type $wpdb 
 */
function fbpp_drop_current_albums(){
	global $wpdb;
	$wpdb->query("TRUNCATE ".FBPP_ALBUM_TBL);
	$wpdb->query("TRUNCATE ".FBPP_PHOTO_TBL);
}

/**
 *
 * @global type $wpdb
 * @param type $photo
 * @param type $album_id 
 */
function fbpp_insert_photo($photo, $album_id){
	global $wpdb;
	$photo_data = array(
		'fbid'=>$photo->id,
		'data'=>json_encode($photo),
		'album_id'=>$album_id,
	);
	$wpdb->insert(FBPP_PHOTO_TBL, $photo_data);
}