$(document).ready(function(){
	var param = 2;
	$('[data-useract="showMoreFavorite"]').click(function(){
		var classTemp = 'resultList' + param;
		
		result = ajaxGet('/ajax/favoriteList/' + user + '/' + param);

		$('#resultList').append('<span class="' + classTemp + '">' + result + '</span>');
		
		if (result.trim() == '') {
			$(this).unbind('click');
			$(this).fadeOut();
		}

		param = param + 1;

		// Unfavorite
		$('#resultList .' + classTemp).on('click', '[data-useract="unfavorite"]', function() {
			clickUnfavorite($(this));
		});

		$('#resultList .' + classTemp).on('click', '[data-useract="addfavorite"]', function() {
			clickAddFavorite($(this));
		});

		$('#resultList .' + classTemp).on('click', '[data-useract="addfriend"]', function() {
			clickAddFriend($(this));
		});

		$('#resultList .' + classTemp).on('click', '[data-useract="unfriend"]', function() {
			clickUnfriend($(this));
		});

		$('#resultList .' + classTemp).on('click', '[data-useract="unrequest"]', function() {
			clickUnrequest($(this));
		});

		$('#resultList .' + classTemp).on('click', '[data-useract="confirm"]', function() {
			clickConfirm($(this));
		});
	});
});