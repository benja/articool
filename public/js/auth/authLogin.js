/* Disable refresh on submit & AJAX */
$(document).ready(function() {
    $('#loginForm').submit(function(event) {
    event.preventDefault();
    });
});

/* Ajax calls */
$('#login_submit').click(function() {

var login_usernameoremail = $('#usernameoremail_address').val();
var login_password = $('#password').val();
var rememberme = $('#remember_me')[0].checked;

$.ajax({
    url: baseUrl + 'auth/login',
    type: 'post',
    data: {
        usernameoremail_address: login_usernameoremail,
        password: login_password,
        remember_me: rememberme
    },
    dataType: 'json',
    success: function (feedback) {

        /* If user logged in, send to profile */
        if(feedback.success == true) {
            setTimeout(function() {
                window.location.href = basePath + 'profile/' + feedback.data.username;
            }, 1000);
        }

        // display error messages properly through our alert div
        if( feedback.success == false) {
            $('#alert_div').removeClass('hidden'); 
            $('#alert_div').removeClass('is-success'); 
            $('#alert_div').addClass('is-error'); 
            $('#alert_title').html('ERROR');
        } else if(feedback.success == true) {
            $('#alert_div').removeClass('hidden');
            $('#alert_div').removeClass('is-error');
            $('#alert_div').addClass('is-success'); 
            $('#alert_title').html('SUCCESS');

            setTimeout(function(){
                $('#alert_div').addClass('hidden');
            }, 2000);
        }

        $('#feedback_message').html(feedback.messages.join('<br />'));
    }
});
    
});


