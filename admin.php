<?php

// start session
if (!session_id())
    session_start();

/**
 * Plugin configuration page
 */
function fbpp_plugin_page() {
    if (isset($_POST['fbpp_action']) && $_POST['fbpp_action'] == 'fetch_albums') {
        // page id
        $page_id = $_POST['page_id'];

        $albums_fetched_data = fbpp_fetch_albums($page_id);

        //list them
        if (!isset($albums_fetched_data->error)) {
            // store in session
            $_SESSION['fbpp_sess_albums'] = $albums_fetched_data;
            $albums_count = 0;
            $albums = array();
            foreach ($albums_fetched_data->data as $album) {
                $al = $album;
                $al->fbpp_coverphoto = fbpp_fetch_photo($album->cover_photo);
                $al->show = TRUE;
                $albums[] = $al;
                $albums_count++;
            }

            include dirname(__FILE__) . '/config-form.php';

            // Add to display
            include dirname(__FILE__) . '/list_albums_view.php';
        } else {
            // TODO error
        }
    } elseif (isset($_POST['fbpp_action']) && $_POST['fbpp_action'] == 'save') {
        $page_id = $_POST['page_id'];
        
        $update = FALSE;
        if ($_SESSION['fbpp_sess_albums']) {
            // save Facebook Page ID
            add_option('fbpp_page_id', $page_id);
            
            $fb_albums = $_SESSION['fbpp_sess_albums'];
            // clear session
            unset($_SESSION['fbpp_sess_albums']);
            // drop currents
            fbpp_drop_current_albums();
        } else {
            // save Facebook Page ID
            update_option('fbpp_page_id', $page_id);
            
            $update = TRUE;
            $fb_albums = new stdClass();
            $db_albums = fbpp_get_all_albums();

            $al = array();
            foreach ($db_albums as $album) {
                $al[] = json_decode($album->data);
            }
            $fb_albums->data = $al;
        }

        $showing_albums = $_POST['albums'];

        foreach ($fb_albums->data as $album) {
            $show = FALSE;
            // if the album fb id not in the shown array hide it
            //echo gettype($album->id);
            foreach ($showing_albums as $key => $val) {
                if ($album->id == $key) {
                    $show = TRUE;
                    break;
                }
            }
            $album_db_id = fbpp_save_album($album, $show);

            if (!$update) {
                $photos = fbpp_fetch_album_photos($album->id);

                // save photos in each album
                if (!isset($photos->error)) {
                    foreach ($photos->data as $photo) {
                        fbpp_insert_photo($photo, $album_db_id);
                    }
                } else {
                    // TODO error of getting photos of each album
                }
            }
        }
        echo '<div class="updated"><p><strong>' . _e('Options saved.') . '</strong></p></div>';
        
        
        $db_albums = fbpp_get_all_albums();
        $albums = array();
        foreach ($db_albums as $album) {
            $al = json_decode($album->data);
            $al->db_id = $album->id;
            $al->show = $album->show;
            // insert cover photo from db
            $al->fbpp_coverphoto = fbpp_get_photo($album->coverphoto_fbid);

            $albums[] = $al;
        }

        include dirname(__FILE__) . '/list_albums_view.php';
            
            
    } else {

        $page_id = get_option(FBPP_WP_OPTION);

        include dirname(__FILE__) . '/config-form.php';

        $db_albums = fbpp_get_all_albums();

        if ($db_albums) {
            $albums = array();
            foreach ($db_albums as $album) {
                $al = json_decode($album->data);
                $al->db_id = $album->id;
                $al->show = $album->show;
                // insert cover photo from db
                $al->fbpp_coverphoto = fbpp_get_photo($album->coverphoto_fbid);

                $albums[] = $al;
            }

            include dirname(__FILE__) . '/list_albums_view.php';
        } else {
            // currently plugin is not confiured.
            echo 'You have not configured plugin.';
        }
    }
}

/**
 * Adds link for configuring plugin
 * This will add a link under plugins 
 */
function fbpp_plugin_page_options() {
    add_plugins_page("Facebook Page Photos Configuration", "FBPP Config", 1, 'fbpp', 'fbpp_plugin_page');
}

add_action('admin_menu', 'fbpp_plugin_page_options');
