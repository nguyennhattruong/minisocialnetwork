<h1>Friend request list</h1>
<div>
	<table class="table no-margin">
		<thead>
			<tr>
				<th width="200" class="text-center">Name</th>
				<th width="100" class="text-center">Sex</th>
				<th width="300" class="text-center">Birthday</th>
				<th class="text-center">Address</th>
				<th width="104"></th>
				<th width="104"></th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($content['request'] as $user): ?>
			<tr>
				<td class="text-middle">
					<a href="<?php route('user/' . $user['username']) ?>">
						<img class="thumbnail reset-thumbnail" width="60" height="60" src="<?php displayAvatar($user['avatar']) ?>">
						<?php echo $user['fullname'] ?>
					</a>
				</td>
				<td class="text-center"><?php echo $user['sex'] ?></td>
				<td class="text-center"><?php echo date('d-m-Y', strtotime($user['birthday'])) ?></td>
				<td><?php echo $user['address'] ?></td>
				<td><?php button('acceptrequest', $user['request_id']) ?></td>
				<td><?php button('removerequest', $user['request_id']) ?></td>
			</tr>
			<?php endforeach ?>
		</tbody>
	</table>
	<span id="resultRequest"></span>
</div>
<div class="clearfix"></div>
<?php if (!empty($content['request'])): ?>
<div class="text-center margin-top">
	<span class="btn btn-primary" data-useract="showMoreRequest"><span class="glyphicon glyphicon-arrow-down" aria-hidden="true"></span> Show more</span>
</div>
<?php endif ?>

<script src="<?php assets('assets/js/view/friend-request.js') ?>" type="text/javascript"></script>	