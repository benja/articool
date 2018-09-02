
/* Disable refresh on submit & AJAX */
$(document).ready(function() {
    $('#authLogout').submit(function(event) {
    event.preventDefault();
    });
});

/* Ajax calls */
$('#logout_submit').click(function() {

var username = $('#session_identifier').val();
var password = $('#session_token').val();

$.ajax({
    url: baseUrl + 'auth/logout',
    type: 'post',
    headers: {
        Authorization: "Basic " + btoa(username + ":" + password)
    },
    dataType: 'json',
    success: function (feedback) {
        window.location.href = basePath;
    }
});
    
});


