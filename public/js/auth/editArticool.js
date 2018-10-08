/* Disable refresh on submit & AJAX */
$(document).ready(function() {

    $('#editArticool').submit(function(event) {
    event.preventDefault();
    });

    $("[type=file]").on("change", function(){
        // Name of file and placeholder
        var file = this.files[0].name;
        var dflt = $(this).attr("placeholder");
        if($(this).val()!=""){
            $('#post_backgroundlabel').text(file);
        } else {
            $('#post_backgroundlabel').text(dflt);
        }
    });

    /* taken from https://stackoverflow.com/questions/22633560/if-checkbox-is-checked-show-input-field-works-in-jsfiddle-not-on-website */
    $(function () {
        //show it when the checkbox is clicked
        $('input[name="is_canonical"]').on('click', function () {
            if ($(this).prop('checked')) {
                $('input[name="canonical_url"]').fadeIn();
            } else {
                $('input[name="canonical_url"').val('');
                $('input[name="canonical_url"]').hide();
            }
        });
    });

    /* Ajax calls */
    $('#articool_submit').click(function() {

    var title = $('#post_title').val();
    var body = post_body.getData();
    var authors = JSON.stringify($('#post_authors').val());
    var language = $('#post_language').val();
    var genre = $('#post_genre').val();
    var postbackground = $('#post_background')[0].files[0];
    var postbackgroundlink = $('#post_backgroundlink').val();
    var canonical_url = $('#canonical_url').val();

    // create formdata
    var data = new FormData();
    data.append('post_title', title);
    data.append('post_body', body);
    data.append('post_authors', authors);
    data.append('post_language', language);
    data.append('post_genre', genre);
    data.append('post_background', postbackground);
    data.append('post_backgroundlink', postbackgroundlink);
    data.append('canonical_url', canonical_url);

    var username = $('#session_identifier').val();
    var password = $('#session_token').val();

    var post_id = window.location.pathname.match(/\/(\d+)/)[1];

        $.ajax({
            url: baseUrl + 'post/edit-articool/' + post_id,
            type: 'post',
            contentType: false,
            processData: false,
            data: data,
            headers: {
                Authorization: "Basic " + btoa(username + ":" + password)
            },
            dataType: 'json',
            success: function (feedback) {

                // display error messages properly through our alert div
                if( feedback.success == false) {
                    $('#alert_div').removeClass('is-success'); 
                    $('#alert_div').addClass('is-error'); 
                    $('#alert_title').html('Whoops, error o.O');
                } else if(feedback.success == true) {
                    $('#alert_div').removeClass('is-error');
                    $('#alert_div').addClass('is-success'); 
                    $('#alert_title').html('Wohoo, success!');
        
                    // update values on the page
                    $('#postpage_title').text(title);
                    $('#postpage_body').html(body);
                    if( $('#post_backgroundlink').val() == null) {
                        $('#postpage_background').css('background-image', 'url(' + $('#post_backgroundlink').val() + ')');
                    }

                    setTimeout(function(){
                        $('#alert_div').removeClass('is-success');
                    }, 2000);
                }

                // i chose not to redirect the user back, incase they want to make a fix again
                $('#feedback_message').html(feedback.messages.join('<br />'));
            }
        });
        
    });

});