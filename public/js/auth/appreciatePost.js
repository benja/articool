
/* Disable refresh on submit & AJAX */
$(document).ready(function() {
    $('#appreciateForm').submit(function(event) {
    event.preventDefault();
    });
});

/* Ajax calls */
$('#post_appreciate').click(function() {

var username = $('#session_identifier').val();
var password = $('#session_token').val();

var post_id = window.location.pathname.match(/\/(\d+)/)[1];

$.ajax({
    url: baseUrl + 'post/like-articool',
    type: 'post',
    data: {
        post_id: post_id
    },
    headers: {
        Authorization: "Basic " + btoa(username + ":" + password)
    },
    dataType: 'json',
    success: function (feedback) {

        if (feedback.success) {
            var text = document.getElementById('appreciate_count');
            var button = $('#post_appreciate');
            var startcount = text.innerHTML;
    
            // change button
            if(button.hasClass("far")) {
                button.addClass("fas");
                button.removeClass("far");

                // add number
                startcount++;
                text.innerHTML = startcount++;
            } else {
                button.addClass("far");
                button.removeClass("fas");
    
                // remove number
                startcount--;
                text.innerHTML= startcount--;

            }
        }

    }
});
    
});


