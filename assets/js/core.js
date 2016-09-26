// Check session
function checkLogin() {
    var flag = false;
    $.ajax({
        type: 'GET',
        url: site_path + '/checkSession',
        async: false,
        success: function(response) {
            if (response == 1) {
                flag = true;
            }
        }
    });
    return flag;
}

function ajaxJson(path, data = '', method = 'GET') {
    if (checkLogin()) {
        var result = '';
        $.ajax({
            type: method,
            url: site_path + path,
            data: data,
            async: false,
            success: function(response) {
                result = response;
            }
        });
        return result;
    } else {
        showNotification('Login to continue.');
        return -1;
    }
}

function ajaxGet(path) {
    if (checkLogin()) {
        var result = '';
        $.ajax({
            type: 'GET',
            url: site_path + path,
            async: false,
            success: function(response) {
                result = response;
            }
        });
        return result;
    } else {
        showNotification('Login to continue.');
        return -1;
    }
}

// Option - Ok/YesNo
function showMessage(json, option = 'ok')
{
    if (option == 'ok') {
        if (json.flag == '0') {
            $('#modalMessageContent').html('<strong>' + json.message + '</strong>');
            $('#modalMessage').modal('show');
        }
    }
    return false;
}

function showNotification(content, title = '')
{
    if (title == '') {
        title = 'Error Message';
    }
    $('#modalMessageTitle').html(title);
    $('#modalMessageContent').html(content);
    $('#modalMessage').modal('show');
}

function showMessageUpload(json, option = 'ok')
{
    if (option == 'ok') {
        if (json.flag == '0') {
            $('#modalMessageContent').html('<strong>' + json.fileName + ' - ' + json.message + '</strong>');
            $('#modalMessage').modal('show');
        }
    }
    return false;
}