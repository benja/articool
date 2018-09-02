/* Disable refresh on submit & AJAX */
$(document).ready(function() {
    $('#forgotPassword').submit(function(event) {
    event.preventDefault();
    });
});

/* Ajax calls */
$('#forgot_submit').click(function() {

var usernameoremail_address = $('#usernameoremail_address').val();

$.ajax({
    url: baseUrl + 'forgot/forgot-password',
    type: 'post',
    data: {
        usernameoremail_address: usernameoremail_address
    },
    dataType: 'json',
    success: function (feedback) {
        $('#feedback_message').html(feedback.messages.join('<br />'));
    }
});
    
});


