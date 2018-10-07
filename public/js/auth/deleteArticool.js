
/* Disable refresh on submit & AJAX */
$(document).ready(function() {
    $('#deleteArticool').submit(function(event) {
    event.preventDefault();
    });
});

/* Ajax calls */
$('#articool_delete').click(function() {
var post_id = window.location.pathname.match(/\/(\d+)/)[1]

var username = $('#session_identifier').val();
var password = $('#session_token').val();

    var forreal = confirm("Do you really wish to delete this Articool?");
    if(forreal == true) {
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
                        var user_username = $('#user_username').val();
                        window.location.href = basePath + 'author/' + user_username;
                    }, 250);
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
                    }, 250);
                }
    
                $('#feedback_message').html(feedback.messages.join('<br />'));
            }
        });
    }
    
});


