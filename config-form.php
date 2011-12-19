<h3>Facebook Page Configurations</h3>
<form action="" method="post" class="validate">
    <input type="hidden" name="fbpp_action" value="fetch_albums" />
    <div class="form-field form-required ">
        <label for="page-id">Page ID: </label>
        <input type="text" id="page-id" name="page_id" size="30" value="<?php echo $page_id; ?>" aria-required="true" />
        <p>ID of the Facebook Page. This appears on page url</p>
    </div>
    <p class="submit">
    <input type="submit" class="button" value="Get Albums" />
    </p>
</form>