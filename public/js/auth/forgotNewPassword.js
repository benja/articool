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




