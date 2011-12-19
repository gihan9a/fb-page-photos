<?php 
if($_POST['fbpp_action'] == 'fetch_albums'){
    echo $albums_count.' albums fetched.';
}
?>
<p>
	Add <b>[fbpp]</b> short code (with brackets) on a post or page, where you need to display the albums.
</p>
<form action="" method="post">
    <input type="hidden" name="fbpp_action" value="save" />
    <input type="hidden" name="page_id" value="<?php echo $page_id; ?>" />
    <div class="form-field form-required ">
        <label for="cols">Number of columns per row: </label>
        <input type="text" id="page-id" name="cols" size="30" value="<?php echo $cols; ?>" aria-required="true" />
        <p>Number of columns should appear on each row. This is a common value for album listing and photos listing</p>
    </div>
    <p class="submit">
        <input type="submit" value="Update" class="button" />
    </p>
    <table class="wp-list-table widefat fixed">
        <thead>
            <tr>
                <th>Name</th>
                <th>Cover photo</th>
                <th>Photos</th>
                <th></th>
            </tr>
        </thead>
        <tr>
        <tfoot>
            <tr>
                <th>Name</th>
                <th>Cover photo</th>
                <th>Photos</th>
                <th></th>
            </tr>
        </tfoot>
        <tbody>
            <?php foreach ($albums as $album): ?>
                <tr>
                    <td>
                        <?php echo $album->name; ?>
                        <?php echo $album->description; ?>
                    </td>
                    <td><img src="<?php echo $album->fbpp_coverphoto->picture; ?>" alt="<?php echo $album->name; ?>" /></td>
                    <td><?php echo $album->count; ?></td>
                    <td>
                        <label><input type="checkbox" name="albums[<?php echo $album->id ?>]" <?php echo ($album->show)?'checked="checked"':''; ?> /> Show</label>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</form>
