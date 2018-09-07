
/* Disable refresh on submit & AJAX */
$(document).ready(function() {
    $('#securitySettings').submit(function(event) {
    event.preventDefault();
    });
});

/* Ajax calls */
$('#settings_submit').click(function() {

var oldpassword = $('#old_password').val();
var newpassword = $('#new_password').val();
var repeatnewpassword = $('#repeat_newpassword').val();

var username = $('#session_identifier').val();
var password = $('#session_token').val();

$.ajax({
    url: baseUrl + 'settings/security-settings',
    type: 'post',
    data: {
        old_password: oldpassword,
        new_password: newpassword,
        repeat_newpassword: repeatnewpassword
    },
    headers: {
        Authorization: "Basic " + btoa(username + ":" + password)
    },
    dataType: 'json',
    success: function (feedback) {
        $('#feedback_message').html(feedback.messages.join('<br />'));
        if(feedback.success == true) {
            document.getElementById("securitySettings").reset();
            $('#settings_submit').prop('disabled', true);

            setTimeout(function() {
                $('#settings_submit').prop('disabled', false);
            }, 3000);
        }
    }
});
    
});


