<?php foreach($albums as $album): ?>
<div class="fbpp-album-thumb" style="width:<?php echo (10 + $album->fbpp_coverphoto->images[2]->width); ?>px">
    <a href="<?php echo $base_url.$album->db_id; ?>" title="<?php echo 'Click to view '.$album->name.' photos'; ?>"><img src="<?php echo $album->fbpp_coverphoto->picture; ?>" /></a>
    <p class="fbpp-album-name"><a href="#"><?php echo $album->name; ?></a></p>
    <p class="fbpp-album-count"><?php echo ($album->count == 1)?$album->count.' Photo':$album->count.' Photos'; ?></p>
</div>
<?php endforeach; ?>