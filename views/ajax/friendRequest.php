<table class="table no-margin">
	<tbody>
	<?php foreach ($content['result'] as $user): ?>
	<tr>
		<td width="200">
			<a href="<?php route('user/' . $user['username']) ?>">
				<img class="thumbnail reset-thumbnail" width="60" height="60" src="<?php displayAvatar($user['avatar']) ?>">
				<?php echo $user['fullname'] ?>
			</a>
		</td>
		<td width="100" class="text-center"><?php echo $user['sex'] ?></td>
		<td width="300" class="text-center"><?php echo date('d-m-Y', strtotime($user['birthday'])) ?></td>
		<td><?php echo $user['address'] ?></td>
		<td width="104">
			<span href="#" class="btn btn-primary" data-useract="acceptrequest" data-requestid="<?php echo $user['request_id'] ?>"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span> Accept</span>
		</td>
		<td width="104">
			<span href="#" class="btn btn-danger" data-useract="removerequest" data-requestid="<?php echo $user['request_id'] ?>"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span> Delete</span>
		</td>
	</tr>
	<?php endforeach ?>
	</tbody>
</table>