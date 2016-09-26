<?php
defined('ACCESS_SYSTEM') or die;

view('layout/header');
?>
<body>
	<section>
		<nav class="main-menu">
			<ul>
				<li><a href="#" title="" class="border-radius"><span class="glyphicon glyphicon-user" aria-hidden="true"></span> Registration</a></li>
				<li><a href="<?php echo route('login') ?>" title="" class="border-radius"><span class="glyphicon glyphicon-share-alt" aria-hidden="true"></span> Login</a></li>
			</ul>
		</nav>
	</section>
</body>
</html>