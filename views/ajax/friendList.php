<?php 
if (isset($content['result'])) {
	foreach ($content['result'] as $friend): ?>
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
						<span title="<?php echo $friend['fullname'] ?>" class="btn btn-default" data-userid="<?php echo $friend['id'] ?>" data-useract="unfriend">Unfriend</span>
					</div>
				</div>
				<div class="clearfix"></div>
			</div>
		</div>
	</div>
<?php endforeach;
} ?>