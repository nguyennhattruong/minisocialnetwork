<script type="text/javascript">
	var user = '<?php echo $content['user']['username'] ?>';
	var latitude = <?php echo $content['latitude'] ?>;
	var longitude = <?php echo $content['longitude'] ?>;
</script>
<script src="<?php assets('assets/js/view/info.js') ?>" type="text/javascript"></script>
<script src="<?php assets('assets/js/map.js') ?>" type="text/javascript" charset="utf-8" async defer></script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBt5Lyjh1t7_ZTZmP7LjizS7RsyTrFVRhI&callback=initMap"></script>

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
		<div role="tabpanel" class="tab-pane active" id="introduction">
			<span id="introButton" class="btn btn-primary btn-sm margin-bottom"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Edit</span>
			<pre style="overflow:auto; max-height:300px" id="introContent"><?php echo $content['user']['about'] ?></pre>
		</div>
		<div role="tabpanel" class="tab-pane" id="picture">
			<div class="clearfix"></div>
			<div class="row">
				<div class="col-sm-4 col-md-2">
					<div id="imageButton"></div>
				</div>
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
						<div class="text-center">
							<span href="#" title="View" class="padding-right">
								<span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span> <?php echo $item['view'] ?>
							</span>
							<span data-liked="<?php echo $liked ?>" style="cursor:pointer" href="#" title="Like" class="padding-right <?php echo $class ?>" data-imageid="<?php echo $item['id'] ?>" data-useract="like">
								<span class="glyphicon glyphicon-thumbs-up" aria-hidden="true"></span> 
								<span class="count"><?php echo $item['like'] ?></span>
							</span>
							<span class="color-gray" style="cursor:pointer" href="#" title="Delete" data-imageid="<?php echo $item['id'] ?>" data-useract="delete">
								<span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
							</span>
						</div>								
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
		<!-- LOCATION -->
		<div role="tabpanel" class="tab-pane" id="location">
			<div id="map"></div>
		</div>
	</div>
</div>
<!-- Suggestion List -->
<?php if (!empty($content['suggestion_list'])): ?>
<div class="margin-top">
	<fieldset>
		<legend>Friend suggestion list</legend>
		<div class="row">
		<?php 
			foreach ($content['suggestion_list'] as $friend): ?>
			<div class="col-xs-4 col-md-2">
				<div class="row">
					<div class="margin-bottom">
						<div class="col-sm-12">
							<div class="user">
								<a href="<?php route('user/' . $friend['username']) ?>" title="<?php echo $friend['fullname'] ?>">
									<img class="thumbnail user-img" src="<?php displayAvatar($friend['avatar']) ?>" alt="<?php echo $friend['fullname'] ?>">
									<div class="user-name"><?php echo $friend['fullname'] ?></div>
								</a>
							</div>
							<div class="text-center">
								<?php button('addfriend', $friend['id']) ?>
							</div>
						</div>
						<div class="clearfix"></div>
					</div>
				</div>
			</div>
		<?php endforeach; ?>
		</div>
	</fieldset>
</div>
<?php endif ?>
<div id="editor" class="modal fade" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">Intro</h4>
			</div>
			<div class="modal-body">
				<textarea class="form-control" style="width:100%; height:300px" id="introEditor"></textarea>
			</div>
			<div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal" id="btnClose">Close</button>
			<button type="button" class="btn btn-primary" id="btnSave">Save</button>
		</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div>