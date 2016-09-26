/*
 * Jquery Upload Image
 * Copyright 2015 by truongnn
 */

(function($){
	$.fn.uploadImage = function(settings) {
		var isFail = false;
		var isCancel = false;

		// Default global variables
		var defaults = {id 				: '#' + $(this).attr('id'),
						inputId			: 'images',
						resultHolderId	: 'resultHolderId',
						resultCaption	: 'resultCaption',
						folderTmp		: 'tmp',
						fileUpload 		: 'ajax/add_image',
						folderImg		: 'uploads/images'};
		
		// Merge default global variables with custom variables
		var options = $.extend(defaults, settings);
		
		// Create for each element
		this.each(function(i) {
			var opt = options;

			// Add element
			$(opt.id).append('<span class="btn btn-default btn-file no-margin"><span><span class="glyphicon glyphicon-plus" aria-hidden="true"></span></span>' +
							 	'<input name="' + opt.inputId + '" id="' + opt.inputId + '" type="file" multiple>' +
							 '</span>');
			
			// Event choose image
			$(opt.id).on('change', '#' + opt.inputId, function(e){
				// Check session
				if (checkLogin()) {
					loadFile();
				} else {
					showNotification('Login to continue!');
				}
			});
			
			function loadFile()
			{
				// Retrieve the FileList object from the referenced element ID
				var myFileList = document.getElementById(opt.inputId).files;
				
				var count = myFileList.length;
				for(i = 0; i < count; i++){
					// Let's upload the complete file object
					uploadFile(myFileList[i]);
				}
			}
			
			function uploadFile(file)
			{
				var formData = new FormData();
			 
				// Append file to the formData
				// Notice the first argument "file" and keep it in mind
				formData.append("file", file);
			 
				// Create XMLHttpRequest Object
				var xhr = new XMLHttpRequest();
				
				xhr.upload.addEventListener("progress", uploadProgress, false);
				xhr.addEventListener("load", uploadComplete, false);
				xhr.addEventListener("error", uploadFailed, false);
				xhr.addEventListener("abort", uploadCanceled, false);
				
				// Open connection using the POST method
				xhr.open("POST", site_path + '/' + opt.fileUpload);
			 
				// Send the file
				xhr.send(formData);
			}
			
			function uploadProgress(evt)
			{
				if (evt.lengthComputable)
				{
					var percentComplete = Math.round(evt.loaded * 100 / evt.total);
					//$(config.id + ' #' + config.alias + '-progress' + iImageTemp).css('width', percentComplete + '%');
				}
				//else 
				//	document.getElementById('progressNumber').innerHTML = 'unable to compute';
			}
			
			function uploadComplete(evt)
			{
				var result = $.parseJSON(evt.target.responseText);
				if(result.flag == 0){
					//alert(result.fileName + ' - ' + result.message);
					showMessageUpload(result);
				}
				else{
					var id = result.id;
					var imageThumb = site_path  + '/img/?img=' + result.filename + '&size=small';
					var image = site_path  + '/img/?img=' + result.filename;

					$('#' + opt.resultHolderId).append('<div class="col-sm-4 col-md-2">' +
					'<div class="thumbnail">' +
						'<a imageid="' + id + '" href="' + image + '" class="fancybox" rel="album">' + 
						'<img style="cursor:pointer" class="margin-bottom" src="' + imageThumb + '"> ' +
						'</a>' +
						'<div class="text-center"> ' +
							'<span href="#" title="View" class="padding-right"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span> <span id="viewimg' + id + '">0</span></span> ' +
							'<span data-liked="0" style="cursor:pointer" href="#" title="Like" class="padding-right color-gray" data-imageid="' + id + '" data-useract="like"><span class="glyphicon glyphicon-thumbs-up" aria-hidden="true"></span> <span class="count">' + 0 + '</span></span> ' +
							'<span class="color-gray" style="cursor:pointer" href="#" title="Delete" data-imageid="' + id + '" data-useract="delete"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></span> ' +
						'</div> ' +								
					'</div> ' +
				'</div>');
				}
			}
			
			function uploadFailed(evt)
			{
				if (isFail == false) {
					showNotification("There are errors.");
					isFail = true;
				}
			}
			
			function uploadCanceled(evt)
			{
				if (isCancel == false) {
					showNotification("Upload process will be interrupted.");
					isCancel = true;
				}
			}
		});
	};
})(jQuery);