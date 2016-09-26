$(document).ready(function(){
	var param = 2;
	$('[data-useract="showMoreRequest"]').click(function(){
		var classTemp = 'resultSearch' + param;

		result = ajaxGet('/ajax/friendRequest/' + param);
		$('#resultRequest').append('<span class="' + classTemp + '">' + result + '</span>');

		if (result.trim() == '') {
			$(this).unbind('click');
			$(this).fadeOut();
		}

		param = param + 1;

		$('#resultRequest .' + classTemp).on('click', '[data-useract="acceptrequest"]', function() {
			clickAcceptRequest($(this));
		});

		$('#resultRequest .' + classTemp).on('click', '[data-useract="removerequest"]', function() {
			clickRemoveRequest($(this));
		});
	});
});