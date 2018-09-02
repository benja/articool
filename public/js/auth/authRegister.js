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

$.ajax({
    url: baseUrl + 'auth/register',
    type: 'post',
    data: {
        username: username,
        first_name: firstname,
        last_name: lastname,
        email_address: email,
        password: password
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


