$('document').ready(function(){
	$('#imageButton').uploadImage({
		folderImg : '<?php echo SITE_PATH . '/' . USER_IMAGE_FOLDER ?>',
		resultHolderId : 'imageHolder'
	});

	// Like, Unlike
	$('#imageHolder').on('click', '[data-useract="like"]', function() {
		clickLike($(this));
	});

	$('#imageHolder').on('click', 'a.fancybox', function() {
	    $(this).fancybox();
	});

	var param = 2;

	$('[data-useract="showMoreImages"]').click(function(){
		result = ajaxGet('/ajax/imageList/' + user + '/' + param);
		if (result != -1) {
			$('#imageHolder').append(result);
			if (result.trim() == '') {
				$(this).unbind('click');
				$(this).fadeOut();
			}
			param = param + 1;
		}
	});

	$('.fancybox').fancybox({
		afterLoad: function(current, previous) {
			var id = this.element[0].getAttribute('imageid');
			var json = ajaxJson('/ajax/view', {'imageid': id}, 'POST');
			if (json != -1) {
				var result = $.parseJSON(json);
				$('#viewimg' + id).text(result.count);
			}
		}
	});

	$("#mapTab").on('shown.bs.tab', function() {
		unlock = true;
	  	/* Trigger map resize event */
		google.maps.event.trigger(map, 'resize');
		map.setCenter(mapCenter);
	});
});