<a class="fbpp-backto-albums" href="<?php echo $album_base_url; ?>">View all albums</a>
<h2><?php echo $album->name; ?></h2>
<p><?php echo $album->description ?></p>
<p><?php echo $album->location; ?></p>
<?php $i=1; foreach($photos as $photo): ?>
<div class="fbpp-photo-thumb">
    <a href="<?php echo $photo->source; ?>" rel="prettyPhoto"><img src="<?php echo $photo->picture; ?>" alt="<?php echo $photo->name ?>" /></a>
</div>
<?php if($i%$cols == 0): ?>
<hr class="fbpp-divider" />
<?php endif; ?>
<?php $i++; endforeach; ?>