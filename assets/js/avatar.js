var flag = false;
  
function loadFile()
{
	// Retrieve the FileList object from the referenced element ID
	var myFileList = document.getElementById('avatar').files;
 
	// Grab the first File Object from the FileList
	var myFile = myFileList[0];
	
	// Let's upload the complete file object
	if (checkLogin()) {
		uploadFile(myFile);
	} else {
		showNotification('Login to continue!');
	}
}
	
function uploadFile(myFileObject)
{
	// Open Our formData Object
	var formData = new FormData();
 
	// Append our file to the formData object
	// Notice the first argument "file" and keep it in mind
	formData.append("file", myFileObject);
 
	// Create our XMLHttpRequest Object
	var xhr = new XMLHttpRequest();
	
	xhr.upload.addEventListener("progress", uploadProgress, false);
	xhr.addEventListener("load", uploadComplete, false);
	xhr.addEventListener("error", uploadFailed, false);
	xhr.addEventListener("abort", uploadCanceled, false);
	
	// Open our connection using the POST method
	xhr.open("POST", site_path + '/ajax/change_avatar');
 
	// Send the file
	xhr.send(formData);
}

function uploadProgress(evt)
{
	if (evt.lengthComputable)
	{
		var percentComplete = Math.round(evt.loaded * 100 / evt.total);
		//document.getElementById('pro').style.width = percentComplete.toString() + 'px';
		$('#image-place').append('<div class="loading"></div>');
	}
	else 
		document.getElementById('progressNumber').innerHTML = 'unable to computer';
}

function uploadComplete(evt)
{
	var result = $.parseJSON(evt.target.responseText);

	if(result.flag == 0) {
		$('#image-url').val('');
		showMessage(result);
	} else {
		$('#image-url').val(result.filename);
		
		$('#image-place').html('');

		// Add Image has uploaded
		$('#image-place').append("<img src='" + site_path + "/avatar/?img=" + result.filename + "&size=small' />");
	}

	$('#image-place .loading').remove();
}

function uploadFailed(evt)
{
	showNotification("There are errors.");
}

function uploadCanceled(evt)
{
	showNotification("Upload process will be interrupted.");
}
	
$(document).ready(function(){
	// Choose file
	$('#avatar').bind('change', function(e){
		loadFile();
	});
});