<!-- Latitude, Longitude -->
<script type="text/javascript">
	var user = '<?php echo $content['user']['username'] ?>';
	var latitude = <?php echo $content['latitude'] ?>;
	var longitude = <?php echo $content['longitude'] ?>;
</script>
<script src="<?php assets('assets/js/view/info-other.js') ?>" type="text/javascript"></script>
<script src="<?php assets('assets/js/map.js') ?>" type="text/javascript" charset="utf-8" async defer></script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBt5Lyjh1t7_ZTZmP7LjizS7RsyTrFVRhI&callback=initMapView"></script>

<div role="tabpanel">
	<!-- Nav tabs -->
	<ul class="nav nav-tabs" role="tablist">
		<li role="presentation" class="active">
			<a href="#introduction" aria-controls="introduction" role="tab" data-toggle="tab">Introduction</a>
		</li>
		<li role="presentation">
			<a href="#picture" aria-controls="picture" role="tab" data-toggle="tab">Picture</a>
		</li>
		<li role="presentation">
			<a id="mapTab" href="#location" aria-controls="tab" role="tab" data-toggle="tab">Location</a>
		</li>
	</ul>
	<!-- Tab panes -->
	<div class="tab-content padding-tb">		
		<div role="tabpanel" class="tab-pane active" id="introduction" ng-controller="userintro">
			<pre style="max-height:300px; overflow:auto"><?php echo $content['user']['about'] ?></pre>
		</div>
		<div role="tabpanel" class="tab-pane" id="picture">
			<div class="row">
				<?php foreach ($content['images'] as $item): ?>
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
						<?php if ($content['is_friend'] == 1): ?>
						<div class="text-center margin-top">
							<span href="#" title="View" class="padding-right"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span> <span id="viewimg<?php echo $item['id'] ?>"><?php echo $item['view'] ?></span></span>
							<span data-liked="<?php echo $liked ?>" style="cursor:pointer" href="#" title="Like" class="padding-right <?php echo $class ?>" data-imageid="<?php echo $item['id'] ?>" data-useract="like"><span class="glyphicon glyphicon-thumbs-up" aria-hidden="true"></span> <span class="count"><?php echo $item['like'] ?></span></span>
						</div>
						<?php else: ?>
						<div class="text-center margin-top">
							<span title="View" class="padding-right color-gray"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span> <?php echo $item['view'] ?></span>
							<span title="Like" class="padding-right color-gray"><span class="glyphicon glyphicon-thumbs-up" aria-hidden="true"></span> <span class="count"><?php echo $item['like'] ?></span></span>
						</div>
						<?php endif ?>					
					</div>
				</div>
				<?php endforeach ?>
				<div id="imageHolder"></div>
				
				<div class="clearfix"></div>
				<?php if (!empty($content['images'])): ?>
				<div class="text-center margin-top">
					<span class="btn btn-primary" data-useract="showMoreImages"><span class="glyphicon glyphicon-arrow-down" aria-hidden="true"></span> Show more</span>
				</div>
				<?php endif ?>
			</div>
		</div>
		<div role="tabpanel" class="tab-pane" id="location">
			<div id="map"></div>
		</div>
	</div>
</div>