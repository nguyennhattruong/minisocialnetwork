$(document).ready(function(){
	var param = 2;
	$('[data-useract="showMoreFriend"]').click(function(){
		var classTemp = 'resultSearch' + param;
		
		result = ajaxGet('/ajax/friendList/' + user + '/' + param);
		$('#resultFriend').append('<span class="' + classTemp + '">' + result + '</span>');
		if (result.trim() == '') {
			$(this).unbind('click');
			$(this).fadeOut();
		}
		param = param + 1;

		$('#resultFriend .' + classTemp).on('click', '[data-useract="unfriend"]', function() {
			clickUnfriend($(this));
		});
	});
});