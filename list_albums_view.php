<form action="fbpp_action=save_fetched" method="get">
    <input type="hidden" name="page_id" value="<?php echo $page_id; ?>" />
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
                        <label><input type="checkbox" name="albums[<?php echo $album->db_id ?>]" <?php echo ($album->show)?'checked="checked"':''; ?> /> Show</label>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</form>