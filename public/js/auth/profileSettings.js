
/* Disable refresh on submit & AJAX */
$(document).ready(function() {
    $('#profileSettings').submit(function(event) {
    event.preventDefault();
    });
});

/* Ajax calls */
$('#settings_submit').click(function() {

var usrname = $('#username').val();
var firstname = $('#first_name').val();
var lastname = $('#last_name').val();
var email = $('#email_address').val();
var desc = $('#description').val();
var avatar = $('#avatar')[0].files[0];

// create formdata
var data = new FormData();
data.append('username', usrname);
data.append('first_name', firstname);
data.append('last_name', lastname);
data.append('email_address', email);
data.append('description', desc);
data.append('avatar', avatar);

var username = $('#session_identifier').val();
var password = $('#session_token').val();

    $.ajax({
        url: baseUrl + 'settings/profile-settings',
        type: 'post',
        contentType: false,
        processData: false,
        data: data,
        headers: {
            Authorization: "Basic " + btoa(username + ":" + password)
        },
        dataType: 'json',
        success: function (feedback) {
            $('#feedback_message').html(feedback.messages.join('<br />'));
            
            if(feedback.success == true) {
                $('#settings_submit').prop('disabled', true);
    
                setTimeout(function() {
                    $('#settings_submit').prop('disabled', false);
                }, 3000);
            }
        }
    });
    
});

// remove avatar

/* Disable refresh on submit & AJAX */
$(document).ready(function() {
    $('#removeAvatar').submit(function(event) {
    event.preventDefault();
    });
});

/* Ajax calls */
$('#avatar__remove').click(function() {

var username = $('#session_identifier').val();
var password = $('#session_token').val();

    $.ajax({
        url: baseUrl + 'settings/profile-settings/remove-avatar',
        type: 'post',
        headers: {
            Authorization: "Basic " + btoa(username + ":" + password)
        },
        dataType: 'json',
        success: function (feedback) {
            $('#feedback_message').html(feedback.messages.join('<br />'));
        }
    });
    
});