/* Disable refresh on submit & AJAX */
$(document).ready(function() {
    $('#editArticool').submit(function(event) {
    event.preventDefault();
    });
});

/* Ajax calls */
$('#articool_submit').click(function() {

var title = $('#post_title').val();
var body = post_body.getData();
var authors = $('#post_authors').val();
var language = $('#post_language').val();
var genre = $('#post_genre').val();

var username = $('#session_identifier').val();
var password = $('#session_token').val();

// get current window location ONLY PATHS, and split them up on the /. This will
// generate a list of the different paths, so we can easily grab the post_id
var url = window.location.pathname.split('/');
var post_id = url[3];

    $.ajax({
        url: baseUrl + 'post/edit-articool/' + post_id,
        type: 'post',
        data: {
            post_title: title,
            post_body: body,
            post_authors: authors,
            post_language: language,
            post_genre: genre
        },
        headers: {
            Authorization: "Basic " + btoa(username + ":" + password)
        },
        dataType: 'json',
        success: function (feedback) {

            // i chose not to redirect the user back, incase they want to make a fix again
            $('#feedback_message').html(feedback.messages.join('<br />'));
        }
    });
    
});


