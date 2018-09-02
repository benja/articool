/* Disable refresh on submit & AJAX */
$(document).ready(function() {
    $('#trendArticool').submit(function(event) {
    event.preventDefault();
    });
});

/* Ajax calls */
$('#articool_trend').click(function() {

// get current window location ONLY PATHS, and split them up on the /. This will
// generate a list of the different paths, so we can easily grab the post_id
var url = window.location.pathname.split('/');
var post_id = url[3];

var username = $('#session_identifier').val();
var password = $('#session_token').val();

    $.ajax({
        url: baseUrl + 'post/trend-articool/',
        type: 'post',
        data: {
            post_id: post_id
        },
        headers: {
            Authorization: "Basic " + btoa(username + ":" + password)
        },
        dataType: 'json',
        success: function (feedback) {

            // change star css on click
            if( $('#trendingStatus').hasClass('fa-star-o') ) {
                $('#trendingStatus').removeClass('fa-star-o');
                $('#trendingStatus').addClass('fa-star');
            } else if( $('#trendingStatus').hasClass('fa-star') ) {
                $('#trendingStatus').removeClass('fa-star');
                $('#trendingStatus').addClass('fa-star-o');
            }

            $('#feedback_message').html(feedback.messages.join('<br />'));
        }
    });
    
});


