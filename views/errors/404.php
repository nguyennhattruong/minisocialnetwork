<?php

defined('ACCESS_SYSTEM') or die;

view('layout/header');
?>
<body>
	<div class="col-md-4 col-md-offset-4">
		<div class="page-error">
			<h1>Not found page!</h1>
			<div class="page-content">
				<a href="<?php route('home') ?>">Go home!</a>
			</div>
		</div>
	</div>
</body>
</html>