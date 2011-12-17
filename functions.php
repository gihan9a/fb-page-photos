<?php
/**
 * Common functions a listed here
 */

/* 
 * Fetch albums from facbook api
 */
function fbpp_fetch_albums($id){
	$url = FB_API_URI.'/'.$id.'/albums';
	$albums = file_get_contents($url);
	return json_decode($albums);
}

/*
 * Fetch single photo from facebook api
 */
function fbpp_fetch_photo($id){
	$url = FB_API_URI.'/'.$id;
	$photo = file_get_contents($url);
	return json_decode($photo);
}

/*
 * Fetch photos of albums from facebook api
 */
function fbpp_fetch_album_photos($id){
	$url = FB_API_URI.'/'.$id.'/photos';
	$photos = file_get_contents($url);
	return json_decode($photos);
}
