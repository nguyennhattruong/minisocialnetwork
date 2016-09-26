<header id="header">
	<nav class="navbar navbar-default bg-indigo no-border no-radius no-margin" role="navigation">
		<div class="container">
			<!-- Brand and toggle get grouped for better mobile display -->
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
			</div>
	
			<!-- Collect the nav links, forms, and other content for toggling -->
			<div class="collapse navbar-collapse navbar-ex1-collapse">
				<form class="navbar-form navbar-left form-search" method="GET" action="<?php route('search') ?>">
					<div class="input-group">
						<span class="input-group-addon no-border no-radius">
							<span class="glyphicon glyphicon-search" aria-hidden="true"></span>
						</span>
						<input name="key" type="text" class="form-control no-border no-radius" placeholder="Search friend" value="<?php echo $content['keyword'] ?>">
					</div>
				</form>
				<ul id="menu-top" class="nav navbar-nav navbar-right">
					<li data-toggle="tooltip" data-placement="left" title="Tooltip on left"><a href="<?php route('home') ?>" class="color-white">Home</a></li>
					<li>
						<a href="<?php route('friend_request') ?>" class="color-white">Friend request
						<?php if ($content['friend_request_quantity'] > 0): ?>
							<span class="notification"><?php echo $content['friend_request_quantity'] ?></span>
						<?php endif ?>
						</a>
					</li>
					<li>
						<a href="<?php route('follow') ?>" class="color-white">Follow list
							<?php if ($content['follow_quantity'] > 0): ?>
								<span class="notification" id="followQuantity"><?php echo $content['follow_quantity'] ?></span>
							<?php endif ?>
						</a>
					</li>
					<li><a href="<?php route('logout') ?>" class="color-white">Logout</a></li>
					<li><a href="" class="color-white">Hi, <?php echo $content['user']['fullname'] ?></a></li>
					<li>
						<img style="margin-top:10px" class="border-radius" width="30" height="30" src="<?php displayAvatar($content['user']['avatar']) ?>" alt="">
					</li>
				</ul>
			</div>
		</div>
	</nav>
</header>