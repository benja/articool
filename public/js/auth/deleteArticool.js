
/* Disable refresh on submit & AJAX */
$(document).ready(function() {
    $('#deleteArticool').submit(function(event) {
    event.preventDefault();
    });
});

/* Ajax calls */
$('#articool_delete').click(function() {
var post_id = window.location.pathname.match(/\/(\d+)/)[1]

var user_username = $('#username').val();

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
                    window.location.href = basePath + 'profile/' + user_username;
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


