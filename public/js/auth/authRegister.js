/* Disable refresh on submit & AJAX */
$(document).ready(function() {
    $('#registerForm').submit(function(event) {
    event.preventDefault();
    });
});

/* Ajax calls */
$('#register_submit').click(function() {

var username = $('#username').val();
var firstname = $('#first_name').val();
var lastname = $('#last_name').val();
var email = $('#email_address').val();
var password = $('#password').val();
var accepttos = $('#accepttos').is(":checked");
var captcha = $('#g-recaptcha-response').val();

$.ajax({
    url: baseUrl + 'auth/register',
    type: 'post',
    data: {
        username: username,
        first_name: firstname,
        last_name: lastname,
        email_address: email,
        password: password,
        accepttos: accepttos,
        captcha: captcha
    },
    dataType: 'json',
    success: function (feedback) {

        /* If user logged in, send to profile */
        if(feedback.success == true) {
            setTimeout(function() {
                window.location.href = basePath + 'author/' + feedback.data.username;
            }, 2500);
        }

        // display error messages properly through our alert div
        if( feedback.success == false) {
            $('#alert_div').removeClass('is-success'); 
            $('#alert_div').addClass('is-error'); 
            $('#alert_title').html('Whoops, error o.O');
        } else if(feedback.success == true) {
            $('#alert_div').removeClass('is-error');
            $('#alert_div').addClass('is-success'); 
            $('#alert_title').html('Wohoo, success!');

            setTimeout(function(){
                $('#alert_div').removeClass('is-success');
            }, 1500);
        }

        $('#feedback_message').html(feedback.messages.join('<br />'));
    }
});
    
});


