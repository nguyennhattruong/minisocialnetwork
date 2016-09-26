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
						<div class="text-center">
							<?php 
							if ($friend['is_friend'] == '1') {
							?>
								<span title="<?php echo $friend['fullname'] ?>" class="btn btn-default" data-userid="<?php echo $friend['id'] ?>" data-useract="unfriend">Unfriend</span>
							<?php
							} elseif ($friend['is_friend'] == '0') {
								if ($friend['is_request'] == '1') {
								?>
									<span title="<?php echo $friend['fullname'] ?>" class="btn btn-success" data-userid="<?php echo $friend['id'] ?>" data-useract="unrequest">Unrequest</span>
								<?php
								} elseif($friend['is_request'] == '2') {
								?>
									<span title="<?php echo $friend['fullname'] ?>" class="btn btn-danger" data-userid="<?php echo $friend['id'] ?>" data-useract="confirm">Confirm</span>
								<?php
								} elseif ($friend['is_request'] == '0') {
								?>
									<span title="<?php echo $friend['fullname'] ?>" class="btn btn-primary" data-userid="<?php echo $friend['id'] ?>" data-useract="addfriend">Add friend</span>
								<?php
								}
								?>
							<?php
							} elseif($friend['is_friend'] == '0') {
							?>
							<span title="<?php echo $friend['fullname'] ?>" class="btn btn-primary" data-userid="<?php echo $friend['id'] ?>" data-useract="addfriend">Add friend</span>
							<?php
							}
							?>
						</div>
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