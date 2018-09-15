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


