
/* Disable refresh on submit & AJAX */
$(document).ready(function() {
    $('#postArticool').submit(function(event) {
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

    $.ajax({
        url: baseUrl + 'post/post-articool',
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
            if(feedback.success == true) {
                setTimeout(function() {
                    window.location.href = basePath + "posts/" + feedback.data.post_id;
                }, 1000);
            }
            $('#feedback_message').html(feedback.messages.join('<br />'));
        }
    });
    
});


