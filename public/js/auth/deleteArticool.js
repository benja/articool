
/* Disable refresh on submit & AJAX */
$(document).ready(function() {
    $('#deleteArticool').submit(function(event) {
    event.preventDefault();
    });
});

/* Ajax calls */
$('#articool_delete').click(function() {

var url = window.location.pathname.split('/');
var post_id = url[3];

var username = $('#session_identifier').val();
var password = $('#session_token').val();

    $.ajax({
        url: baseUrl + 'post/delete-articool/' + post_id,
        type: 'delete',
        data: {
            post_id: post_id
        },
        headers: {
            Authorization: "Basic " + btoa(username + ":" + password)
        },
        dataType: 'json',
        success: function (feedback) {
            if(feedback.success == true) {
                setTimeout(function() {
                    window.location.href = basePath;
                }, 1000);
            }
            $('#feedback_message').html(feedback.messages.join('<br />'));
        }
    });
    
});


