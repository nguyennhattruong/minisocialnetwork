var app = angular.module("app", ["xeditable", "ui.bootstrap"]);

app.run(function(editableOptions) {
  	editableOptions.theme = 'bs3';
});

var scope;

$(document).ready(function() {
	var flagMenu = false;
	// Active menu
	$('#menu-top>li>a').each(function() {
		if($(this).attr('href') == window.location) {
			flagMenu = true;
		    $(this).parent().addClass("active");
		    return false;
		}
    });

    if (!flagMenu) {
    	$('#menu-top>li').first().addClass("active");
    }

	// Accept request
	$('[data-useract="acceptrequest"]').click(function() {
		clickAcceptRequest($(this));
	});

	$('[data-useract="removerequest"]').click(function() {
		clickRemoveRequest($(this));
	});

	// Add friend
	$('[data-useract="addfriend"]').click(function() {
		clickAddFriend($(this));
	});

	$('[data-useract="confirm"]').click(function() {
		clickConfirm($(this));
	});

	$('[data-useract="unfriend"]').click(function() {
		clickUnfriend($(this));
	});

	$('[data-useract="unrequest"]').click(function() {
		clickUnrequest($(this));
	});

	// Unfavorite
	$('[data-useract="unfavorite"]').click(function() {
		clickUnfavorite($(this));
	});

	// Addfavorite
	$('[data-useract="addfavorite"]').click(function() {
		clickAddFavorite($(this));
	});

	// Add follow
	$('[data-useract="addfollow"]').click(function() {
		clickAddFollow($(this));
	});	

	$('[data-useract="unfollow"]').click(function() {
		clickUnfollow($(this));
	});

	// Like, Unlike
	$('[data-useract="like"]').click(function() {
		clickLike($(this));
	});

	$('[data-useract="delete"]').click(function() {
		clickDelete($(this));
	});
});

function clickAcceptRequest(that) {
	var json = ajaxJson('/ajax/acceptrequest', {'requestid': that.attr('data-requestid')}, 'POST');
	if (json != -1) {
		var result = $.parseJSON(json);
		if (result.flag == 1) {
			that.parent().parent().fadeOut('normal');
		} else {
			showNotification('There is error.', 'Accept request');
		}
	}
}

function clickRemoveRequest(that) {
	bootbox.confirm("Are you sure remove request?", function(flag) {
			if (flag) {
				var json = ajaxJson('/ajax/removerequest', {'requestid': that.attr('data-requestid')}, 'POST');
				if (json != -1) {
					var result = $.parseJSON(json);
					if (result.flag == 1) {
						that.parent().parent().fadeOut('normal');
					} else {
						showNotification('There is error.', 'Remove request');
					}
				}
			}
		}
	);
}

function clickAddFriend(that) {
	var attr = that.attr('data-useract');
	if (attr == 'addfriend') {
		addFriend(that);
	} else if (attr == 'unrequest') {
		unRequest(that);
	}
}
function clickConfirm(that) {
	var json = ajaxJson('/ajax/addfriend', {'userid': that.attr('data-userid')}, 'POST');
	if (json != -1) {
		var result = $.parseJSON(json);
		if (result.flag == 1) {
			location.reload();
		} else {
			showNotification('There is error.', 'Confirm request');
		}
	}
}

function clickUnfriend(that) {
	var attr = that.attr('data-useract');
	if (attr == 'unfriend') {
		unfriend(that);
	} else if (attr == 'addfriend') {
		addFriend(that);
	} else if (attr == 'unrequest') {
		unRequest(that);
	}
}

function clickUnrequest(that) {
	var attr = that.attr('data-useract');
	if (attr == 'unrequest') {
		unRequest(that);
	} else if (attr == 'addfriend') {
		addFriend(that);
	}
}

function clickUnfavorite(that) {
	var attr = that.attr('data-useract');
	if (attr == 'unfavorite') {
		unfavorite(that);
	} else if (attr == 'addfavorite') {
		addfavorite(that);
	}
}

function clickAddFavorite(that) {
	var attr = that.attr('data-useract');
	if (attr == 'addfavorite') {
		addfavorite(that);
	} else if (attr == 'unfavorite') {
		unfavorite(that);
	}
}

function clickAddFollow(that) {
	var attr = that.attr('data-useract');
	if (attr == 'addfollow') {
		addfollow(that);
	} else if (attr == 'unfollow') {
		unfollow(that);
	}
}

function clickUnfollow(that) {
	var attr = that.attr('data-useract');
	if (attr == 'unfollow') {
		unfollow(that);
	} else if (attr == 'addfollow') {
		addfollow(that);
	}
}

function clickLike(that) {
	var type = 'Like';
	var json = ajaxJson('/ajax/like', {'imageid': that.attr('data-imageid')}, 'POST');
	if (json != -1) {
		var result = $.parseJSON(json);
		if (result.flag == 1) {
			if (that.attr('data-liked') == 1) {
				type = 'Unlike';
				that.attr('data-liked', 0);
				that.removeClass('color-indigo').addClass('color-gray');
			} else {
				that.attr('data-liked', 1);
				that.removeClass('color-gray').addClass('color-indigo');
			}
			that.children('.count').text(result.count);
		} else {
			showNotification('There is error.', type);
		}
	}
}

function clickDelete(that) {
	bootbox.confirm("Are you sure delete photo?", function(flag) {
		if (flag) {
			var json = ajaxJson('/ajax/delete', {'imageid': that.attr('data-imageid')}, 'POST');
			if (json != -1) {
				var result = $.parseJSON(json);
				if (result.flag == 1) {
					that.parent().parent().parent().fadeOut('normal');
				} else {
					showNotification('There is error.', 'Delete Image');
				}
			}
		}
	});
}

// Function
function addFriend(that) {
	var json = ajaxJson('/ajax/addfriend', {'userid': that.attr('data-userid')}, 'POST');
	if (json != -1) {
		var result = $.parseJSON(json);
		if (result.flag == 1) {
			that.text('Unrequest');
			that.attr('data-useract', 'unrequest');
			that.removeClass('btn-primary').addClass('btn-success');
		} else {
			showNotification('There is error.', 'Add Friend');
		}
	}
}

function unRequest(that) {
	bootbox.confirm("Are you sure unrequest?", function(flag) {
			if (flag) {
				var json = ajaxJson('/ajax/unrequest', {'userid': that.attr('data-userid')}, 'POST');
				if (json != -1) {
					var result = $.parseJSON(json);
					if (result.flag == 1) {
						that.text('Add Friend');
						that.attr('data-useract', 'addfriend');
						that.removeClass('btn-success').addClass('btn-primary');
					} else {
						showNotification('There is error.', 'Unrequest');
					}
				}
			}
		}
	);
}

function unfriend(that) {
	bootbox.confirm("Are you sure unfriend?", function(flag) {
			if (flag) {
				var json = ajaxJson('/ajax/unfriend', {'userid': that.attr('data-userid')}, 'POST');
				if (json != -1) {
					var result = $.parseJSON(json);
					if (result.flag == 1) {
						location.reload();
					} else {
						showNotification('There is error.', 'Unfriend');
					}
				}
			}
		}
	);
}

function unfavorite(that) {
	bootbox.confirm("Are you sure unfavorite?", function(flag) {
			if (flag) {
				var json = ajaxJson('/ajax/unfavorite', {'userid': that.attr('data-userid')}, 'POST');
				if (json != -1) {
					var result = $.parseJSON(json);
					if (result.flag == 1) {
						that.text('Add favorite');
						that.attr('data-useract', 'addfavorite');
						that.removeClass('btn-default').addClass('btn-primary');
					} else {
						showNotification('There is error.', 'Unfavorite');
					}
				}
			}
		}
	);
}

function addfavorite(that) {
	var json = ajaxJson('/ajax/addfavorite', {'userid': that.attr('data-userid')}, 'POST');
	if (json != -1) {
		var result = $.parseJSON(json);
		if (result.flag == 1) {
			that.text('Unfavorite');
			that.attr('data-useract', 'unfavorite');
			that.removeClass('btn-primary').addClass('btn-default');
		} else {
			showNotification('There is error.', 'Add Favorite');
		}
	}
}

function unfollow(that) {
	bootbox.confirm("Do you want to unfollow?", function(flag) {
			if (flag) {
				var json = ajaxJson('/ajax/unfollow', {'userid': that.attr('data-userid')}, 'POST');
				if (json != -1) {
					var result = $.parseJSON(json);
					if (result.flag == 1) {
						that.text('Add follow');
						that.attr('data-useract', 'addfollow');
						that.removeClass('btn-default').addClass('btn-primary');
					} else {
						showNotification('There is error.', 'Unfollow');
					}
				}
			}
		}
	);
}

function addfollow(that) {
	var json = ajaxJson('/ajax/addfollow', {'userid': that.attr('data-userid')}, 'POST');
	if (json != -1) {
		var result = $.parseJSON(json);
		if (result.flag == 1) {
			that.text('Unfollow');
			that.attr('data-useract', 'unfollow');
			that.removeClass('btn-primary').addClass('btn-default');
		} else {
			showNotification('There is error.', 'Add follow');
		}
	}
}