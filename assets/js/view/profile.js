app.controller('user', function($scope, $filter) {
	scope = $scope;
	$scope.user = {
		name: profileName,
		nameOld: profileName,
		email: profileEmail,
		emailOld: profileEmail,
		address: document.getElementById('hAddress').value,
		addressOld: document.getElementById('hAddress').value,
		sex : profileSex,
		sexOld : profileSex,
		birthday : profileBirthday,
		birthdayOld : profileBirthday
	};

	$scope.updateUserName = function() {
		var json = ajaxJson('/ajax/update/username', {fullname : $scope.user.name}, 'POST');
		if (json != -1) {
			var result = $.parseJSON(json);
			if (result.flag == '0') {
				scope.user['name'] = scope.user['nameOld'];
			} else {
				scope.user['nameOld'] = scope.user['name'];
			}
			showMessage(result);
		} else {
			scope.user['name'] = scope.user['nameOld'];
		}
	};

	$scope.updateEmail = function() {
		var json = ajaxJson('/ajax/update/email', {email : $scope.user.email}, 'POST');
		if (json != -1) {
			var result = $.parseJSON(json);
			if (result.flag == '0') {
				scope.user['email'] = scope.user['emailOld'];
			} else {
				scope.user['emailOld'] = scope.user['email'];
			}
			showMessage(result);
		} else {
			scope.user['email'] = scope.user['emailOld'];
		}
	};

	$scope.updateAddress = function() {
		var json = ajaxJson('/ajax/update/address', {address : $scope.user.address}, 'POST');
		if (json != -1) {
			var result = $.parseJSON(json);
			if (result.flag == '0') {
				scope.user['address'] = scope.user['addressOld'];
			} else {
				scope.user['addressOld'] = scope.user['address'];
			}
			showMessage(result);
		} else {
			scope.user['address'] = scope.user['addressOld'];
		}
	};

	$scope.updateSex = function() {
		var json = ajaxJson('/ajax/update/sex', {sex : $scope.user.sex}, 'POST');
		if (json != -1) {
			var result = $.parseJSON(json);
			if (result.flag == '0') {
				scope.user['sex'] = scope.user['sexOld'];
			} else {
				scope.user['sexOld'] = scope.user['sex'];
			}
			showMessage(result);
		} else {
			scope.user['sex'] = scope.user['sexOld'];
		}
	};

	$scope.updateBirthday = function() {
		var date = $scope.user.birthday;
		var json;
		if (date instanceof Date)
		{
			var d = date.getFullYear() + '/' + (date.getMonth() + 1) + '/' + date.getDate();
			json = $.parseJSON(ajaxJson('/ajax/update/birthday', {birthday : d}, 'POST'));
		} else {
			json = {flag : '0', message : 'Birthday is incorrect.'};
		}
		
		if (json.flag == '0') {
			scope.user['birthday'] = scope.user['birthdayOld'];
		} else {
			scope.user['birthdayOld'] = scope.user['birthday'];
		}

		showMessage(json);
	};

	$scope.opened = {};

	$scope.open = function($event, elementOpened) {
		$event.preventDefault();
		$event.stopPropagation();

		$scope.opened[elementOpened] = !$scope.opened[elementOpened];
	};

	$scope.sexes = [
	    {value: '1', text: 'Male'},
	    {value: '2', text: 'Female'},
	];

	$scope.showSex = function() {
	    var selected = $filter('filter')($scope.sexes, {value: $scope.user.sex});
	    return ($scope.user.sex && selected.length) ? selected[0].text : 'Not set';
	};
});