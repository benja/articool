/**
 * Functions
 */

function createTitleSlug(text)
{
  return text.toString().toLowerCase()
    .replace(/\s+/g, '-')           // Replace spaces with -
    .replace(/[^\w\-]+/g, '')       // Remove all non-word chars
    .replace(/\-\-+/g, '-')         // Replace multiple - with single -
    .replace(/^-+/, '')             // Trim - from start of text
    .replace(/-+$/, '');            // Trim - from end of text
}

 /**
  * Functions
  */

/* Disable refresh on submit & AJAX */
$(document).ready(function() {
    $('#postArticool').submit(function(event) {
    event.preventDefault();
    });
});

/* Ajax calls */
$('#articool_submit').click(function() {

var title = $('#post_title').val();
var title_slug = createTitleSlug(title);
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
                    window.location.href = basePath + "posts/" + feedback.data.post_id + "/" + title_slug;
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


