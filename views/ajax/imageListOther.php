<?php foreach ($content['result'] as $item): ?>
<?php
$class = 'color-gray';
$liked = 0;
if ($item['liked'] > 0) { $class = 'color-indigo'; $liked = 1; }
?>
<div class="col-sm-4 col-md-2">
	<div class="thumbnail">
		<a imageid="<?php echo $item['id'] ?>" class="fancybox" rel="album" href="<?php displayImage($item['image'], false) ?>">
			<img style="cursor:pointer" class="margin-bottom" src="<?php displayImage($item['image']) ?>" alt="">
		</a>
		<div class="text-center">
			<span href="#" title="View" class="padding-right"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span> <span id="viewimg<?php echo $item['id'] ?>"><?php echo $item['view'] ?></span></span>
			<span data-liked="<?php echo $liked ?>" style="cursor:pointer" href="#" title="Like" class="padding-right <?php echo $class ?>" data-imageid="<?php echo $item['id'] ?>" data-useract="like"><span class="glyphicon glyphicon-thumbs-up" aria-hidden="true"></span> <span class="count"><?php echo $item['like'] ?></span></span>
		</div>								
	</div>
</div>
<?php endforeach ?>