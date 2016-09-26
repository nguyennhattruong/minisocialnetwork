<script type="text/javascript">
	var key = '<?php echo $content['key'] ?>';
</script>
<script src="<?php assets('assets/js/view/friend-search.js') ?>" type="text/javascript"></script>
<div class="row">
	<?php
		foreach ($content['list'] as $friend): ?>
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
							<?php
							if ($friend['is_confirm'] == 0) {
								button('addfriend', $friend['id']);
							} else {
								button('confirm', $friend['id']);
							}
							?>
						</div>
					</div>
				</div>
			</div>
		</div>
	<?php endforeach; ?>
	<span id="resultSearch"></span>
	<div class="clearfix"></div>
	<?php if (!empty($content['list'])): ?>
	<div class="text-center margin-top">
		<span class="btn btn-primary" data-useract="showMoreSearch"><span class="glyphicon glyphicon-arrow-down" aria-hidden="true"></span> Show more</span>
	</div>
	<?php endif ?>
</div>