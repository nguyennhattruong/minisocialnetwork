$(document).ready(function(){
	var param = 2;
	$('[data-useract="showMoreSearch"]').click(function(){
		var classTemp = 'resultSearch' + param;

		result = ajaxGet('/ajax/searchFriend/' + key + '/' + param);
		$('#resultSearch').append('<span class="' + classTemp + '">' + result + '</span>');
		
		if (result.trim() == '') {
			$(this).unbind('click');
			$(this).fadeOut();
		}

		param = param + 1;

		$('#resultSearch .' + classTemp).on('click', '[data-useract="addfriend"]', function() {
			clickAddFriend($(this));
		});

		$('#resultSearch .' + classTemp).on('click', '[data-useract="unfriend"]', function() {
			clickUnfriend($(this));
		});

		$('#resultSearch .' + classTemp).on('click', '[data-useract="unrequest"]', function() {
			clickUnrequest($(this));
		});

		$('#resultSearch .' + classTemp).on('click', '[data-useract="confirm"]', function() {
			clickConfirm($(this));
		});
	});
});