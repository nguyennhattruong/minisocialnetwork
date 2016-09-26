<script type="text/javascript">
	var profileName = '<?php echo addslashes($content['user']['fullname']) ?>';
	var profileEmail = '<?php echo addslashes($content['user']['email']) ?>';
	var profileSex = '<?php echo $content['user']['sex'] ?>';
	var profileBirthday = new Date(<?php echo date('Y', strtotime($content['user']['birthday'])) ?>, <?php echo date('m', strtotime($content['user']['birthday'])) - 1 ?>, <?php echo date('d', strtotime($content['user']['birthday'])) ?>);
</script>
<script src="<?php assets('assets/js/view/profile.js') ?>" type="text/javascript"></script>

<input type="hidden" id="hAddress" value="<?php echo $content['user']['address'] ?>" placeholder="">
<div>
	<div class="row margin-bottom">
		<div class="col-xs-6 col-sm-3">
			<div>
				<input id="image-old" name="image-old" type="hidden" value=""/>
                <input id="image-url" name="image-url" type="hidden" value="default" />
                <div id="upload-image" class="upload-image">
					<span class="btn btn-primary btn-upload no-margin">
						<span><span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Change</span>
						<input name="image" id="avatar" type="file">
					</span>
					<div id="image-place">
						<?php if ($content['user']['avatar'] != ''): ?>
							<img src="<?php displayAvatar($content['user']['avatar']) ?>" alt="">
						<?php endif ?>
					</div>
                </div>
			</div>
		</div>
		<div class="col-xs-12 col-sm-9">
			<div ng-controller="user">
				<div>
					<h2 class="no-margin-top" editable-text="user.name" e-form="userNameForm" onaftersave="updateUserName()" e-maxlength="30"><a href="<?php route('user/' . $content['user']['username']) ?>">{{ user.name || user.nameOld }}</a></h2>
					<a class="btn btn-primary btn-sm" href="" title="" ng-click="userNameForm.$show()" ng-hide="userNameForm.$visible"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Edit</a>
				</div>
				<div class="margin-bottom"></div>
				<div>
					<div class="row">
						<div class="col-sm-3 margin-bottom">
							Email:
						</div>
						<div class="col-sm-6 margin-bottom">
							<span editable-text="user.email" e-form="emailForm" onaftersave="updateEmail()" e-maxlength="100">{{ user.email || user.emailOld }}</span>
						</div>
						<div class="col-sm-3 margin-bottom">
							<a class="btn btn-primary btn-sm" href="" title="" ng-click="emailForm.$show()" ng-hide="emailForm.$visible"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Edit</a>	
						</div>
					</div>
					<div class="row">
						<div class="col-sm-3 margin-bottom">
							Birthday:
						</div>
						<div class="col-sm-6 margin-bottom">
							<span editable-bsdate="user.birthday" e-is-open="opened.$data" e-ng-click="open($event,'$data')" e-datepicker-popup="dd-MM-yyyy" e-form="birthdayForm" onaftersave="updateBirthday()">{{ (user.birthday | date:"dd/MM/yyyy") || (user.birthdayOld | date:"dd/MM/yyyy") }}</span>
						</div>
						<div class="col-sm-3 margin-bottom">
							<a class="btn btn-primary btn-sm" href="" title="" ng-click="birthdayForm.$show()" ng-hide="birthdayForm.$visible"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Edit</a>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-3 margin-bottom">
							Sex:
						</div>
						<div class="col-sm-6 margin-bottom">
							<span editable-select="user.sex" e-ng-options="s.value as s.text for s in sexes" e-form="sexForm" onaftersave="updateSex()">{{ showSex() }}</span>
						</div>
						<div class="col-sm-3 margin-bottom">
							<a class="btn btn-primary btn-sm" href="" title="" ng-click="sexForm.$show()" ng-hide="sexForm.$visible"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Edit</a>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-3 margin-bottom">
							Address:
						</div>
						<div class="col-sm-6 margin-bottom">
							<div style="overflow:auto" id="user_address" editable-text="user.address" e-form="addressForm" onaftersave="updateAddress()">{{ user.address || user.addressOld }}</div>
						</div>
						<div class="col-sm-3 margin-bottom">
							<a class="btn btn-primary btn-sm" href="" title="" ng-click="addressForm.$show()" ng-hide="addressForm.$visible"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Edit</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div>
		<ul class="list-text">
			<li><a href="<?php echo route('friends/' . $content['user']['username']) ?>" title="">Friend list (<?php echo $content['friend_list_quantity'] ?>)</a></li>
			<li><a href="<?php echo route('favorite/' . $content['user']['username']) ?>" title="">Favorite list (<?php echo $content['favorite_quantity'] ?>)</a></li>
		</ul>
	</div>
</div>