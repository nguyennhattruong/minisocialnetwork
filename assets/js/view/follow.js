$(document).ready(function(){
	var param = 1;
	
	$('[data-useract="showMoreFollow"]').click(function(){
		result = ajaxGet('/ajax/followList/' + param);
		$('#resultFollow').append(result);
		if (result.trim() == '') {
			$(this).unbind('click');
			$(this).fadeOut();
		}

		var json = ajaxJson('/ajax/countFollow');
		if (json != -1) {
			var resultCount = $.parseJSON(json);
			$('#followQuantity').text(resultCount.count);
		}
	});
});