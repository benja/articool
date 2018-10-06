/* Disable refresh on submit & AJAX */
$(document).ready(function() {
    $('#trendArticool').submit(function(event) {
    event.preventDefault();
    });
});

/* Ajax calls */
$('#articool_trend').click(function() {

var post_id = window.location.pathname.match(/\/(\d+)/)[1]

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
            if( $('#trendingStatus').hasClass('far fa-star') ) {
                $('#trendingStatus').removeClass('far fa-star');
                $('#trendingStatus').addClass('fas fa-star');
            } else if( $('#trendingStatus').hasClass('fas fa-star') ) {
                $('#trendingStatus').removeClass('fas fa-star');
                $('#trendingStatus').addClass('far fa-star');
            }

            $('#feedback_message').html(feedback.messages.join('<br />'));
        }
    });
    
});


