<?php
defined('ACCESS_SYSTEM') or die;

view('layout/header');
?>
<body ng-app="app">	
	<?php viewComposer('toolbar') ?>
	<section class="container bg-white padding-tb">
		<?php echo $content ?>
	</section>
	<footer id="footer" class="container bg-indigo padding color-white">
		Copyright &copy; 2016
	</footer>
	<!-- Begin: Modal -->
	<div id="modalMessage" class="modal fade" tabindex="-1" role="dialog">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="modalMessageTitle">Error Message</h4>
				</div>
				<div class="modal-body">
					<p id="modalMessageContent"></p>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>
	<!-- End: Modal -->
</body>
</html>