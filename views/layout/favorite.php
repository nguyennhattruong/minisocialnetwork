<script type="text/javascript">
	var user = '<?php echo $content['user']['username'] ?>';
</script>
<script src="<?php assets('assets/js/view/favorite.js') ?>" type="text/javascript"></script>
<div class="row">
	<?php 
	if (!empty($content['favorites'])) {
		foreach ($content['favorites'] as $friend): ?>
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
							if ($friend['is_friend'] === '1') {
								button('unfriend-sm', $friend['id']);
							} else {
								if ($friend['is_request'] == '1') {
									button('unrequest-sm', $friend['id']);
								} elseif ($friend['is_request'] == '2') {
									button('confirm-sm', $friend['id']);
								}
								else {
									button('addfriend-sm', $friend['id']);
								}
							}
							?>
							<?php button('unfavorite-sm', $friend['id']); ?>
						</div>
					</div>
					<div class="clearfix"></div>
				</div>
			</div>
		</div>
	<?php endforeach;
	} ?>
	<span id="resultList"></span>
	<span class="clearfix"></span>
	<?php if (!empty($content['favorites'])): ?>
	<div class="text-center margin-top">
		<span class="btn btn-primary" data-useract="showMoreFavorite"><span class="glyphicon glyphicon-arrow-down" aria-hidden="true"></span> Show more</span>
	</div>
	<?php endif ?>
</div>