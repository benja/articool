/* Disable refresh on submit & AJAX */
$(document).ready(function() {
    $('#forgotNewPassword').submit(function(event) {
    event.preventDefault();
    });
});

/* Ajax calls */
$('#forgot_submit').click(function() {

var password = $('#password').val();
var confirm_password = $('#confirm_password').val();

var url = window.location.pathname.split('/');
var token = url[3];

$.ajax({
    url: baseUrl + 'forgot/set-new-password/' + token,
    type: 'post',
    data: {
        password: password,
        confirm_password: confirm_password
    },
    dataType: 'json',
    success: function (feedback) {

        /* If user logged in, send to profile */
        if(feedback.success == true) {
            setTimeout(function() {
                window.location.href = basePath + 'profile/' + feedback.data.username;
            }, 1000);
        }
        
        $('#feedback_message').html(feedback.messages.join('<br />'));
    }
});
    
});




