<div>
	<div class="row">
		<div class="col-xs-6 col-sm-3">
			<a href="" title="" class="thumbnail">
				<img src="<?php displayAvatar($content['user']['avatar']) ?>" alt="" width="100%">
			</a>
		</div>
		<div class="col-xs-12 col-sm-9">
			<div ng-controller="user">
				<div>
					<h2 class="no-margin-top"><a href="<?php route('user/' . $content['user']['username']) ?>"><?php echo $content['user']['fullname'] ?></a></h2>
				</div>
				<div class="margin-bottom"></div>
				<div>
					<div class="row">
						<div class="col-sm-3 margin-bottom">
							Email:
						</div>
						<div class="col-sm-6 margin-bottom">
							<span><?php echo $content['user']['email'] ?></span>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-3 margin-bottom">
							Birthday:
						</div>
						<div class="col-sm-6 margin-bottom">
							<span><?php echo date('d-m-Y', strtotime($content['user']['birthday'])) ?></span>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-3 margin-bottom">
							Sex:
						</div>
						<div class="col-sm-6 margin-bottom">
							<span><?php echo $content['user']['sex_name'] ?></span>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-3 margin-bottom">
							Address:
						</div>
						<div class="col-sm-6 margin-bottom">
							<span><?php echo $content['user']['address'] ?></span>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-12">
						    <?php 
						    // friend
						    if ($content['is_friend'] == 1) {
						    	button('unfriend', $content['user']['id']);
						    } else {
						    	if ($content['is_request']['request_type'] == 1) {
						    		button('unrequest', $content['user']['id']);
						    	} elseif ($content['is_request']['request_type'] == 2) {
						    		button('confirm', $content['user']['id']);
						    	} else {
						    		button('addfriend', $content['user']['id']);
						    	}
						    }

						    echo '<span style="margin-right:10px"></span>';

						    // favorite
						    if ($content['is_favorite'] == 1) {
						    	button('unfavorite', $content['user']['id']);
						    } else {
						    	button('addfavorite', $content['user']['id']);
						    }

						    echo '<span style="margin-right:10px"></span>';
						    
						    // follow
						    if ($content['is_follow'] == 1) {
						    	button('unfollow', $content['user']['id']);
						    } else {
						    	button('addfollow', $content['user']['id']);
						    }
						    ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div>
		<ul class="list-text">
			<li><a href="<?php echo route('friends/' . $content['user']['username']) ?>" title="">Friend list (<?php echo $content['friend_list_quantity'] ?>)</a></li>
			<li><a href="<?php echo route('favorite/' . $content['user']['username']) ?>" title="">Favorite list (<?php echo $content['favorite_quantity'] ?>)</a></li>
		</ul>
	</div>
</div>