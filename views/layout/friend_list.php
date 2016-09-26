<script type="text/javascript">
	var user = '<?php echo $content['user']['username'] ?>';
</script>
<script src="<?php assets('assets/js/view/friend-list.js') ?>" type="text/javascript"></script>
<div class="row">
	<?php 
	if (isset($content['friends'])) {
		foreach ($content['friends'] as $friend): ?>
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
						<div class="text-center"><?php button('unfriend', $friend['id']) ?></div>
					</div>
					<div class="clearfix"></div>
				</div>
			</div>
		</div>
	<?php endforeach;
	} ?>
	<span id="resultFriend"></span>
</div>
<div class="clearfix"></div>
<?php if (!empty($content['friends'])): ?>
<div class="text-center margin-top">
	<span class="btn btn-primary" data-useract="showMoreFriend"><span class="glyphicon glyphicon-arrow-down" aria-hidden="true"></span> Show more</span>
</div>
<?php endif ?>