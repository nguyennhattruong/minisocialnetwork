<h2>Follow list</h2>
<table class="table table-striped">
	<tbody>
		<?php 
		foreach ($content['follow'] as $item):
		?>
		<tr>
			<td class="padding">
				<a href="<?php route('user/' . $item['username']) ?>">
					<img class="thumbnail reset-thumbnail" width="60" height="60" src="<?php displayAvatar($item['avatar']) ?>" alt="">
					<?php echo $item['fullname'] ?>
				</a>
			</td>
			<td class="padding"><strong><?php echo $item['action'] ?></strong></td>
			<td class="padding">
				<a href="<?php route('user/' . $item['username1']) ?>">
					<img class="thumbnail reset-thumbnail" width="60" height="60" src="<?php displayAvatar($item['avatar1']) ?>" alt="">
					<?php echo $item['fullname1'] ?>
				</a>
			</td>
			<td>
				<?php if ($item['is_new'] == 1): ?>
					<span class="btn btn-danger btn-sm"><span class="glyphicon glyphicon-fire" aria-hidden="true"></span> New</span>
				<?php endif ?>
			</td>
		</tr>
		<?php endforeach ?>
	</tbody>
	<tbody id="resultFollow"></tbody>
</table>

<div class="clearfix"></div>
<?php if (!empty($content['follow'])): ?>
<div class="text-center margin-top">
	<span class="btn btn-primary" data-useract="showMoreFollow"><span class="glyphicon glyphicon-arrow-down" aria-hidden="true"></span> Show more</span>
</div>
<?php endif ?>

<script src="<?php assets('assets/js/view/follow.js') ?>" type="text/javascript"></script>