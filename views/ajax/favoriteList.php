<?php 
if (!empty($content['result'])) {
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
						<?php
							if ($friend['is_user'] != '1') {
								if ($friend['is_friend'] == '1') {
									button('unfriend-sm', $friend['id']);
								} elseif ($friend['is_friend'] == '0') {
									if ($friend['is_request'] == '1') {
										button('unrequest-sm', $friend['id']);
									} elseif($friend['is_request'] == '2') {
										button('confirm-sm', $friend['id']);
									} elseif ($friend['is_request'] == '0') {
										button('addfriend-sm', $friend['id']);
									}
								} elseif($friend['is_friend'] == '0') {
									button('addfriend-sm', $friend['id']);
								}
								echo '<span style="margin-right:4px"></span>';
								button('unfavorite-sm', $friend['id']);
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