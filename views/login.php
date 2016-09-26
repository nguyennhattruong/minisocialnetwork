<?php
defined('ACCESS_SYSTEM') or die;

view('layout/header');
?>
<body class="login">
	<div class="col-sm-4 col-sm-offset-4">
		<div class="form-login">
			<?php 
			if (Session::hasFlash('error')) {
			?>
			<div class="alert alert-danger">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
				<strong><?php echo Session::getFlash('error') ?></strong>
			</div>
			<?php
			}
			?>
			<form action="<?php echo route('login') ?>" method="post">
				<div class="form-group">
					<input type="text" class="form-control" name="username" placeholder="Username" autofocus>
				</div>
				<div class="form-group">
					<input type="password" class="form-control" name="password" placeholder="Password">
				</div>
				<div class="form-group text-center">
					<button style="padding-left:50px; padding-right:50px" type="submit" class="btn btn-primary">Login</button>
				</div>
				<div class="text-center" style="margin-top:7px">
					<a href="<?php route('') ?>"><span class="glyphicon glyphicon-share-alt" aria-hidden="true"></span> Go home</a>
				</div>
				<div class="clearfix"></div>
			</form>
		</div>
	</div>
</body>
</html>