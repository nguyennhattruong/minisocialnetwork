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
						<?php if ($friend['is_confirm'] == 0): ?>
						<span class="btn btn-default" data-userid="<?php echo $friend['id'] ?>" data-useract="addfriend">Add friend</span>
						<?php else: ?>
						<span class="btn btn-danger" data-userid="<?php echo $friend['id'] ?>" data-useract="confirm">Comfirm</span>
						<?php endif ?>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php endforeach; ?>